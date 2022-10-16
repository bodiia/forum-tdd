<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
{
    public function store(ReplyRequest $request, Channel $channel, Thread $thread): RedirectResponse
    {
        $attributes = [...$request->validated(), 'user_id' => auth()->id()];

        $thread->replies()->create($attributes);

        return to_route('threads.show', ['channel' => $channel, 'thread' => $thread])
            ->with('success', 'Reply was created!');
    }

    public function destroy(Reply $reply): RedirectResponse
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        return back()->with('success', 'Reply was deleted!');
    }

    public function update(Request $request, Reply $reply): RedirectResponse
    {
        $this->authorize('update', $reply);

        $validator = Validator::make($request->all(), [
            'body' => 'required|min:3|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'reply');
        }

        $reply->update($validator->validated());

        return back()->with('success', 'Reply was updated!');
    }
}
