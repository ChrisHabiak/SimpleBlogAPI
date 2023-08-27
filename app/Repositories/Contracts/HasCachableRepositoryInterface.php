<?php

namespace App\Repositories\Contracts;

interface HasCachableRepositoryInterface
{
    public function paginateFromCache($page, $columns);

    public function showFromCache($id, $columns);
}
