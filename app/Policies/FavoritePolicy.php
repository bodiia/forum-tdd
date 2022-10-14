<?php

namespace App\Policies;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FavoritePolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Favorite $favorite): bool
    {
        return $favorite->user()->is($user);
    }
}
