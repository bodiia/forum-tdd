<?php

declare(strict_types=1);

namespace App\Actions\Favorites;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

final class MarkAsFavoriteAction
{
    public static function execute(Model $model, User $user): void
    {
        if (! $model->favorites()->whereBelongsTo($user)->exists()) {
            /** @var Favorite $favorite */
            $favorite = $model->favorites()->make();
            $favorite->user()->associate($user);
            $favorite->save();
        }
    }
}
