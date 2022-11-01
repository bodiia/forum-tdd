<?php

namespace App\Http\Controllers;

use App\Filters\ThreadsFilter;
use App\Http\Requests\ThreadRequest;
use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThreadController extends Controller
{
    public function index(Request $request, ThreadsFilter $filters): View|JsonResponse
    {
        $threads = Thread::query()->filter($filters)->latest()->get();

        if ($request->wantsJson()) {
            return response()->json($threads);
        }

        return view('threads.index', compact('threads'));
    }

    public function create(): View
    {
        return view('threads.create');
    }

    public function store(ThreadRequest $request): RedirectResponse
    {
        $attributes = [...$request->validated(), 'user_id' => auth()->id()];

        $thread = Thread::query()->create($attributes);

        return to_route('threads.show', ['channel' => $thread->channel, 'thread' => $thread])
            ->with('success', __('flash.thread.created'));
    }

    public function show(Channel $channel, Thread $thread): View
    {
        $replies = $thread->replies()->paginate(10);

        auth()->user()?->read($thread);

        return view('threads.show', compact('thread', 'replies'));
    }

    public function edit(Thread $thread)
    {
        //
    }

    public function update(Request $request, Thread $thread)
    {
        //
    }

    public function destroy(Channel $channel, Thread $thread): RedirectResponse
    {
        $this->authorize('delete', $thread);

        $thread->delete();

        return to_route('threads.index')->with('success', __('flash.thread.deleted'));
    }
}
