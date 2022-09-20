<?php

namespace App\Http\Controllers;

use App\Models\Reply;

class FavoriteController extends Controller
{
    public function store(Reply $reply)
    {
        $attributes = ['user_id' => auth()->id()];

        if (! $reply->favorites()->where($attributes)->exists()) {
            return $reply->favorites()->create($attributes);
        }
    }
}
