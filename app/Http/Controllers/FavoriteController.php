<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Reply;

class FavoriteController extends Controller
{
    public function store(Reply $reply)
    {
        $reply->favorite();

        return back();
    }

    public function destroy(Reply $reply, Favorite $favorite)
    {
        $this->authorize('delete', $favorite);

        $favorite->delete();

        return back()->with('success', 'This reply is now unfavorited');
    }
}
