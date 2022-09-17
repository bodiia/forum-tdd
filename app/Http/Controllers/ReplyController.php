<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Models\Reply;
use App\Models\Thread;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreReplyRequest $request, Thread $thread)
    {
        $reply = new Reply($request->validated());

        $reply->owner()->associate(auth()->user());
        $reply->thread()->associate($thread);
        $reply->save();

        return to_route('threads.show', $thread)->with('success', 'Reply was created!');
    }
}
