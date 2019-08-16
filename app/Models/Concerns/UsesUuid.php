<?php

namespace thimstory\Models\Concerns;

use Illuminate\Support\Str;

/**
 * This trait allows Laravel to use all uuid's instead of id's
 * Just use 'thimstory\Models\Concerns\UsesUuid;'
 *
 * Trait UsesUuid
 * @package thimstory\Models\Concerns
 */
trait UsesUuid
{
    /**
     * booting function
     */
    protected static function bootUsesUuid()
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * uuid id's can't be incremented
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Must be string for uuid
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}