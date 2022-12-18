<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Favoritable
{
    protected static function bootFavoritable(): void
    {
        static::deleting(static function (self $model) {
            $model->favorites->each->delete();
        });
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function whereFavorite(User $user): ?Favorite
    {
        return $this->favorites->firstWhere('user_id', $user->id);
    }
}
