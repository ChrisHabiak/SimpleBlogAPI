<?php

namespace App\Repositories;

use App\Events\UserRegisteredEvent;
use App\Jobs\SendUserResetPasswordLinkMailJob;
use App\Models\PasswordReset;
use App\Models\User;
use App\Repositories\Contracts\HasCachableRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Traits\HasCachableRepositoryTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Repository for managing User related data and actions.
 */
class UserRepository extends EloquentRepository implements UserRepositoryInterface, HasCachableRepositoryInterface
{

    use HasCachableRepositoryTrait;

    /**
     * Constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Register a new user.
     *
     * @param array $userData
     * @return User
     */
    public function register(array $userData)
    {
        // Create user with hashed password
        $user = User::create(['password' => Hash::make($userData['password'])] + $userData);

        // Trigger event for user registration
        event(new UserRegisteredEvent($user));

        return $user;
    }

    /**
     * Authenticate user login.
     *
     * @param array $userData
     * @return User|null
     * @throws ValidationException
     */
    public function login(array $userData)
    {

        // TODO: Improve caching logic to fetch a single record's tag using getCacheTagSingleRecord instead of the getCacheTagFromClass method

        $user = Cache::tags([User::getCacheTagFromClass()])
            ->rememberForever('users-' . $userData['email'], function () use ($userData) {
                return User::where('email', $userData['email'])
                    ->with('role:id,permissions')
                    ->select(['id', 'name', 'password', 'role_id'])
                    ->first();
            });

        // Check credentials
        if (!$user || !Hash::check($userData['password'], $user->password)) {
            throw ValidationException::withMessages(['email' => 'The email or password is incorrect']);
        }

        if (!$user->role) {
            throw ValidationException::withMessages(['email' => 'You do not have permission to the admin panel']);
        }

        // Log in the user
        Auth::loginUsingId($user->id);

        return $user;
    }

    /**
     * Store a new user.
     *
     * @param array $userData
     * @return User
     */
    public function create(array $userData)
    {
        // Create user with hashed password
        return User::create(['password' => Hash::make($userData['password'])] + $userData);
    }

    /**
     * Update a user by ID.
     *
     * @param int $userID
     * @param array $userData
     * @return bool
     */
    public function update($userID, array $userData)
    {
        // If password is not provided, remove it from the data
        if (empty($userData['password'])) {
            unset($userData['password']);
        } else {
            // Otherwise, hash the provided password
            $userData['password'] = Hash::make($userData['password']);
        }

        // Clear cached data related to the entity
        (new $this->model)->clearCache();

        // Update the user data
        return User::whereId($userID)->update($userData);
    }

    /**
     * Reset user password.
     *
     * @param string $userPasswordResetToken
     * @param string $userEmail
     * @param string $plainPassword
     * @return bool
     */
    public function resetPassword($userPasswordResetToken, $userEmail, $plainPassword): bool
    {
        // Find the password reset record
        $passwordReset = PasswordReset::where('email', $userEmail)
            ->where('token', $userPasswordResetToken)
            ->select(['email', 'token'])
            ->first();

        if (!$passwordReset) {
            return false;
        }

        // Check token validity
        if (!hash_equals($passwordReset->token, $userPasswordResetToken)) {
            return false;
        }

        // Update user password and delete password reset record
        User::where('email', $userEmail)->update(['password' => Hash::make($plainPassword)]);
        PasswordReset::where('email', $userEmail)->delete();

        return true;
    }

    /**
     * Send a reset password link to the user.
     *
     * @param string $userEmail
     * @return bool
     */
    public function sendResetPasswordLink($userEmail): bool
    {
        // Find the user
        $user = User::select(['id', 'name', 'email'])->where('email', $userEmail)->first();

        if (!$user) {
            return false;
        }

        SendUserResetPasswordLinkMailJob::dispatch(
            $user,
            PasswordReset::updateOrCreate(['email' => $userEmail])->getToken()
        );

        return true;
    }

    /**
     * Log out the current user.
     *
     * @return void
     */
    public function logoutCurrentUser()
    {
        Auth::logout();
    }
}
