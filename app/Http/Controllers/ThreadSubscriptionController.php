<?php

namespace App\Http\Controllers;

use App\Actions\ThreadSubscriptions\SubscribeUserAction;
use App\Actions\ThreadSubscriptions\UnsubscribeUserAction;
use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ThreadSubscriptionController extends Controller
{
    public function __construct(
        private readonly SubscribeUserAction $subscribeUserAction,
        private readonly UnsubscribeUserAction $unsubscribeUserAction,
    ) {
    }

    public function store(Thread $thread, Request $request): RedirectResponse
    {
        $this->subscribeUserAction->execute($request->user(), $thread);

        return back()->with('success', __('flash.subscription.created'));
    }

    public function destroy(Thread $thread, Request $request): RedirectResponse
    {
        $this->unsubscribeUserAction->execute($request->user(), $thread);

        return back()->with('success', __('flash.subscription.deleted'));
    }
}
