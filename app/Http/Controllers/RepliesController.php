<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function store(Request $request, Thread $thread)
    {
        $attributes = $request->validate([
            'body' => 'required|min:10|max:255',
        ]);

        $reply = new Reply($attributes);

        $reply->owner()->associate(auth()->user());
        $reply->thread()->associate($thread);
        $reply->save();

        return to_route('threads.show', $thread)->with('success', 'Reply was created!');
    }
}
