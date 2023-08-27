<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Arr;

/**
 * Policy for authorizing post-related actions.
 */
class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Perform checks before any other authorization methods.
     *
     * @param User|null $user
     * @param string $ability
     * @return bool
     */
    public function before(?User $user, $ability)
    {
        // Allow viewing any posts
        if ($ability == 'viewAny' || $ability == 'view') {
            return true;
        }

        // Check user's role permissions for other abilities
        if ($user) {
            return Arr::get($user->role, 'permissions.posts.' . $ability, false);
        }
    }

    /**
     * Determine whether the user can view any posts.
     *
     * @param User|null $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function view(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param User|null $user
     * @return bool
     */
    public function create(?User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function delete(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
