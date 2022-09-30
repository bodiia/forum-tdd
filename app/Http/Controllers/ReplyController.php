<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;

class ReplyController extends Controller
{
    public function store(StoreReplyRequest $request, Channel $channel, Thread $thread)
    {
        $attributes = [...$request->validated(), 'user_id' => auth()->id()];

        $thread->replies()->create($attributes);

        return to_route('threads.show', ['channel' => $channel, 'thread' => $thread])
            ->with('success', 'Reply was created!');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        return redirect()->back()->with('success', 'Reply was deleted!');
    }
}
