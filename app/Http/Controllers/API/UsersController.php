<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

/**
 * Controller handling user-related actions.
 */
class UsersController extends Controller
{
    /**
     * UserRepositoryInterface instance.
     *
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * Create the controller instance, set repository and authorize resource by policy.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->authorizeResource(User::class, User::class);
    }

    /**
     * Show cached users.
     *
     * @return UserCollection
     */
    public function index()
    {
        return new UserCollection($this->userRepository->paginateFromCache(
            request('page', 1),
            ['id', 'name', 'email', 'role_id']
        ));
    }

    /**
     * Save user.
     *
     * @param UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $this->userRepository->create($request->validated());

        return response()->noContent();
    }

    /**
     * Show user by id.
     *
     * @param $userID
     * @return UserResource
     */
    public function show($userID)
    {
        return new UserResource($this->userRepository->showFromCache($userID));
    }

    /**
     * Update user by id.
     *
     * @param UserUpdateRequest $request
     * @param $userID
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $userID)
    {
        $this->userRepository->update($userID, $request->validated());

        return response()->noContent();
    }

    /**
     * Delete user by id.
     *
     * @param $userID
     * @return \Illuminate\Http\Response
     */
    public function destroy($userID)
    {
        $this->userRepository->delete($userID);

        return response()->noContent();
    }
}
