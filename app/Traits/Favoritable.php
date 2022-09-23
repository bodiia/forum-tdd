<?php

namespace App\Traits;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Favoritable
{
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

    public function favoritesCount(): Attribute
    {
        return Attribute::get(
            fn () => $this->favorites->count(),
        );
    }
}
