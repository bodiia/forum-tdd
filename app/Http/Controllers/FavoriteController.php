<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Reply;

class FavoriteController extends Controller
{
    public function store(Reply $reply)
    {
        $attributes = ['user_id' => auth()->id()];

        if (! $reply->favorites()->where($attributes)->exists()) {
            $reply->favorites()->create($attributes);
        }

        return back();
    }

    public function destroy(Reply $reply, Favorite $favorite)
    {
        $this->authorize('delete', $favorite);

        $favorite->delete();

        return back()->with('success', 'This reply is now unfavorited');
    }
}
