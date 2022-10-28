<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\RedirectResponse;

class ThreadSubscriptionController extends Controller
{
    public function store(Thread $thread): RedirectResponse
    {
        $thread->subscribe(auth()->user());

        return back()->with('success', __('flash.subscription.created'));
    }

    public function destroy(Thread $thread): RedirectResponse
    {
        $this->authorize('delete', $thread->getSubscriptionByUser(auth()->user()));

        $thread->unsubscribe(auth()->user());

        return back()->with('success', __('flash.subscription.deleted'));
    }
}
