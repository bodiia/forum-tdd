<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreReplyRequest $request, Channel $channel, Thread $thread)
    {
        $attributes = $request->validated();
        $attributes['user_id'] = auth()->id();
        $attributes['thread_id'] = $thread->id;

        Reply::query()->create($attributes);

        return to_route('threads.show', ['channel' => $thread->channel, 'thread' => $thread])
            ->with('success', 'Reply was created!');
    }
}
