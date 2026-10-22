<?php

namespace app\model;

use Illuminate\Support\Str;
use Rennokki\QueryCache\Traits\QueryCacheable;
use support\Model;

/**
 *
 */
class BaseModel extends Model
{
    use QueryCacheable;

    protected static bool $flushCacheOnUpdate = true;

    public int $cacheFor = 300;

    protected string $cacheDriver = 'query';

    public function cacheTagsValue(): array
    {
        $class = str_replace(['App\\Models\\', 'app\\model\\'], '', static::class);

        return [strtolower(Str::plural($class))];
    }

    protected function getCacheBaseTags(): array
    {
        $class = str_replace(['App\\Models\\', 'app\\model\\'], '', static::class);

        return [strtolower(Str::plural($class))];
    }
    
}
