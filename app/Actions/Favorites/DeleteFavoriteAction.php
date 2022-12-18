<?php

declare(strict_types=1);

namespace App\Actions\Favorites;

use App\Models\Favorite;

final class DeleteFavoriteAction
{
    public static function execute(Favorite $favorite): void
    {
        $favorite->delete();
    }
}
