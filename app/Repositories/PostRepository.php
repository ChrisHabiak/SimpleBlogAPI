<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\HasCachableRepositoryInterface;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Repositories\Traits\HasCachableRepositoryTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostRepository extends EloquentRepository implements PostRepositoryInterface, HasCachableRepositoryInterface
{
    use HasCachableRepositoryTrait;

    public function __construct(Post $model)
    {
        parent::__construct($model);
    }


    public function create(array $modelData)
    {

        $this->uploadPhoto($modelData);

        return Post::create($modelData);
    }

    public function update($postId, array $modelData)
    {

        $this->uploadPhoto($modelData);

        return Post::findOrFail($postId)->update($modelData);

    }

    public function uploadPhoto(array &$modelData)
    {

        if (isset($modelData['photo']) && $modelData['photo'] instanceof UploadedFile) {
            $modelData['image_url'] = Storage::url($modelData['photo']->storePublicly('posts'));
        }

    }

}

