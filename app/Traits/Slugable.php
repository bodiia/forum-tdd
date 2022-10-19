<?php

declare(strict_types=1);

namespace App\Traits;

trait Slugable
{
    protected static function bootSlugable(): void
    {
        static::creating(static function (self $model) {
            $field = $model->slugable();
            $model->slug = str($model->$field)->slug()->toString();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    abstract protected function slugable(): string;
}
