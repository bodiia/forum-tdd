<?php

namespace App\Http\Controllers;

use App\Actions\ThreadSubscriptions\SubscribeUserAction;
use App\Actions\ThreadSubscriptions\UnsubscribeUserAction;
use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ThreadSubscriptionController extends Controller
{
    public function store(Thread $thread, Request $request): RedirectResponse
    {
        SubscribeUserAction::execute($request->user(), $thread);

        return Redirect::back()->with('success', __('flash.subscription.created'));
    }

    public function destroy(Thread $thread, Request $request): RedirectResponse
    {
        UnsubscribeUserAction::execute($request->user(), $thread);

        return Redirect::back()->with('success', __('flash.subscription.deleted'));
    }
}
