<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;

/**
 * Controller handling post-related actions.
 */
class PostsController extends Controller
{
    /**
     * PostRepositoryInterface instance.
     *
     * @var PostRepositoryInterface
     */
    private PostRepositoryInterface $postRepository;

    /**
     * Create the controller instance, set repository and authorize resource by policy.
     *
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;

        $this->authorizeResource(Post::class, Post::class);
    }

    /**
     * Show cached posts.
     *
     * @return PostCollection
     */
    public function index()
    {
        return new PostCollection(
            $this->postRepository->paginateFromCache(
                request('page', 1),
                ['id', 'title', 'content', 'image_url']
            ));
    }

    /**
     * Save post.
     *
     * @param PostStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        $this->postRepository->create($request->validated());

        return response()->noContent();
    }

    /**
     * Show post by id.
     *
     * @param $postID
     * @return PostResource
     */
    public function show($postID)
    {
        return new PostResource($this->postRepository->showFromCache($postID,  ['id', 'title', 'content', 'image_url']));
    }

    /**
     * Update post by id.
     *
     * @param PostStoreRequest $request
     * @param $postID
     * @return \Illuminate\Http\Response
     */
    public function update(PostStoreRequest $request, $postID)
    {
        $this->postRepository->update($postID, $request->validated());

        return response()->noContent();
    }

    /**
     * Delete post by id.
     *
     * @param $postID
     * @return \Illuminate\Http\Response
     */
    public function destroy($postID)
    {
        $this->postRepository->delete($postID);

        return response()->noContent();
    }
}
