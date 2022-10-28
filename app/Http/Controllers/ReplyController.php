<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Notifications\NotifySubscribersAboutCreatedReply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
{
    public function store(ReplyRequest $request, Channel $channel, Thread $thread): RedirectResponse
    {
        $attributes = [...$request->validated(), 'user_id' => auth()->id()];

        $reply = $thread->replies()->create($attributes);

        $thread->subscriptions
            ->filter(fn ($subscription) => ! $subscription->subscriber()->is(auth()->user()))
            ->each(fn ($subscription) => $subscription->subscriber->notify(
                new NotifySubscribersAboutCreatedReply($thread, $reply))
            );

        return to_route('threads.show', ['channel' => $channel, 'thread' => $thread])
            ->with('success', __('flash.reply.created'));
    }

    public function destroy(Reply $reply): RedirectResponse
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        return back()->with('success', __('flash.reply.deleted'));
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

        return back()->with('success', __('flash.reply.updated'));
    }
}
