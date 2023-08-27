<?php

namespace App\Repositories\Contracts;

/**
 * The interface for User repositories
 */
interface UserRepositoryInterface
{
    /**
     * Register a new user.
     *
     * @param array $userData
     * @return \App\Models\User
     */
    public function register(array $userData);

    /**
     * Authenticate user login.
     *
     * @param array $userData
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function login(array $userData);

    /**
     * Reset user password.
     *
     * @param string $userPasswordResetToken
     * @param string $userEmail
     * @param string $plainPassword
     * @return bool
     */
    public function resetPassword(string $userPasswordResetToken, string $userEmail, string $plainPassword);

    /**
     * Send reset password link to user email.
     *
     * @param string $userEmail
     * @return bool
     */
    public function sendResetPasswordLink(string $userEmail);

    /**
     * Log out the current user.
     *
     * @return void
     */
    public function logoutCurrentUser();
}
