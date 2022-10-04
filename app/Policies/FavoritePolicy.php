<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Favorite;
use Illuminate\Auth\Access\HandlesAuthorization;

class FavoritePolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Favorite $favorite)
    {
        return $favorite->user()->is($user);
    }
}
