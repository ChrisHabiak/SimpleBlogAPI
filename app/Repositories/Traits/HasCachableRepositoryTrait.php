<?php

namespace App\Repositories\Traits;

use App\Repositories\Contracts\HasCachableRepositoryInterface;

/**
 * Trait HasCacheTrait
 *
 * This trait provides caching functionality for models.
 */
trait HasCachableRepositoryTrait
{
    public function paginateFromCache($page, $columns)
    {
        return $this->model->paginateFromCache($page, $columns);
    }

    public function showFromCache($id, $columns)
    {
        return $this->model->showFromCache($id, $columns);
    }

}
