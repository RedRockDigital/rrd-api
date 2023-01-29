<?php

namespace RedRockDigital\Api\Traits;

use Exception;
use Illuminate\Support\Str;

/**
 * Trait HasUuid
 */
trait HasUuid
{
    /**
     * Apply a key if one is not already present
     *
     * @throws Exception
     */
    protected static function bootHasUuid(): void
    {
        static::creating(static function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}
