<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Trait HasCacheTrait
 *
 * This trait provides caching functionality for models.
 */
trait HasCacheTrait
{
    /**
     * Sets up the events to clear cache when a model is saved or deleted.
     */
    public static function bootHasCacheTrait(): void
    {
        static::saved(function ($model) {
            $model->clearCache();
        });

        static::deleted(function ($model) {
            $model->clearCache();
        });
    }

    /**
     * Returns cache tag name based on class name.
     *
     * @return string Cache tag name.
     */
    public static function getCacheTagFromClass(): string
    {
        return Str::slug(get_called_class());
    }

    /**
     * Returns cache tag name based on class name.
     *
     * @return string Cache tag name.
     */
    public static function getCacheTagSingleRecord($id): string
    {
        return self::getCacheTagFromClass() . '-' . $id;
    }


    /**
     * Clears entity's cache tagged by class name.
     */
    public function clearCache(): void
    {
        Cache::tags(self::getCacheTagFromClass())->flush();
        Cache::tags(self::getCacheTagSingleRecord($this->id))->flush();
    }


    /**
     * Paginates results and caches the response.
     *
     * @param array $columns The columns to be fetched. Default is ['*'] to fetch all columns.
     * @return mixed Paginated response from cache.
     */
    public static function paginateFromCache(string|int $page, array $columns = ['*']): mixed
    {
        $tag = self::getCacheTagFromClass();

        return
            Cache::tags([$tag])
                ->rememberForever($tag . 'page' . $page . 'columns' . join(',', $columns), function () use ($columns) {
                    return get_called_class()::orderBy('id', 'desc')->paginate(10, $columns);
                });
    }

    /**
     * Fetches a certain entity by ID and caches the response.
     *
     * @param string|int $id
     * @param array $columns
     * @return mixed Entity response from cache.
     */
    public function showFromCache(string|int $id, array $columns = ['*']): mixed
    {
        $tag = self::getCacheTagSingleRecord($id);

        return
            Cache::tags([$tag])
                ->rememberForever($tag . 'columns' . join(',', $columns), function () use ($columns, $id) {
                    return get_called_class()::select($columns)->find($id);
                });
    }
}
