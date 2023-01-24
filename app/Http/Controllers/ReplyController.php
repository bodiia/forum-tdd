<?php

namespace App\Http\Controllers;

use App\Actions\Replies\DeleteReplyAction;
use App\Actions\Replies\StoreReplyAction;
use App\Actions\Replies\UpdateReplyAction;
use App\DTOs\Replies\StoreReplyDto;
use App\DTOs\Replies\UpdateReplyDto;
use App\Http\Requests\ReplyRequest;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
{
    public function __construct(
        private readonly StoreReplyAction $storeReplyAction,
        private readonly UpdateReplyAction $updateReplyAction,
        private readonly DeleteReplyAction $deleteReplyAction,
    ) {
    }

    public function store(ReplyRequest $request, Channel $channel, Thread $thread): RedirectResponse
    {
        $this->storeReplyAction->execute(
            $thread,
            StoreReplyDto::fromRequest($request)
        );

        return to_route('threads.show', ['channel' => $channel, 'thread' => $thread])
            ->with('success', __('flash.reply.created'));
    }

    public function destroy(Reply $reply): RedirectResponse
    {
        $this->authorize('delete', $reply);

        $this->deleteReplyAction->execute($reply);

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

        $this->updateReplyAction->execute(
            $reply,
            UpdateReplyDto::fromArray($validator->validated())
        );

        return back()->with('success', __('flash.reply.updated'));
    }
}
