<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Favoritable
{
    protected static function bootFavoritable(): void
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorited(): Attribute
    {
        return Attribute::get(
            fn () => $this->favorites->where('user_id', auth()->id())->isNotEmpty(),
        );
    }

    public function favoriteByUser(): Attribute
    {
        return Attribute::get(
            fn () => $this->favorites()->where('user_id', auth()->id())->first(),
        );
    }

    public function favoritesCount(): Attribute
    {
        return Attribute::get(
            fn () => $this->favorites->count(),
        );
    }

    public function favorite(): void
    {
        $attributes = ['user_id' => auth()->id()];

        if (! $this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }
    }
}
