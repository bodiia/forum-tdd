<?php

declare(strict_types=1);

namespace App\Actions\Favorites;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

final class MarkAsFavoriteAction
{
    public static function execute(Model $model, User $user): void
    {
        $attributes = ['user_id' => $user->id];

        if (! $model->favorites()->whereBelongsTo($user)->exists()) {
            $model->favorites()->create($attributes);
        }
    }
}
