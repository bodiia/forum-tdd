<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class ThreadSubscriptionController extends Controller
{
    public function store(Thread $thread): RedirectResponse
    {
        $thread->subscribe(auth()->user());

        return back()->with('success', 'You have subscribed to the thread!');
    }

    public function destroy(Thread $thread): RedirectResponse
    {
        $this->authorize('delete', $thread->subscriptions()->firstWhere('user_id', auth()->id()));

        $thread->unsubscribe(auth()->user());

        return back()->with('success', 'You unsubscribed from the thread!');
    }
}
