<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserResetPasswordRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Controller handling user authentication and related actions.
 */
class AuthController extends Controller
{
    /**
     * UserRepositoryInterface instance.
     *
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * AuthController constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a new user.
     *
     * @param UserStoreRequest $request
     * @return UserResource
     */
    public function register(UserRegisterRequest $request)
    {
        return new UserResource(
            $this->userRepository->register($request->validated())
        );
    }

    /**
     * Log in a user.
     *
     * @param UserLoginRequest $request
     * @return UserResource
     */
    public function login(UserLoginRequest $request)
    {
        return new UserResource(
            $this->userRepository->login($request->validated())
        );
    }

    /**
     * Send a reset password link to the user's email.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetPasswordLink(Request $request)
    {
        return response()->json([
            'success' => $this->userRepository->sendResetPasswordLink($request->get('email'))
        ]);
    }

    /**
     * Reset user's password.
     *
     * @param UserResetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(UserResetPasswordRequest $request)
    {
        return response()->json([
            'success' => $this->userRepository->resetPassword(
                $request->get('token'),
                $request->get('email'),
                $request->get('password')
            )
        ]);
    }

    /**
     * Log out the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $this->userRepository->logoutCurrentUser();

        return response()->noContent();
    }
}
