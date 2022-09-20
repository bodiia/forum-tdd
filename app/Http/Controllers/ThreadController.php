<?php

namespace App\Http\Controllers;

use App\Filters\ThreadsFilter;
use App\Http\Requests\StoreThreadRequest;
use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index(Request $request, ThreadsFilter $filters)
    {
        $threads = Thread::query()
            ->filter($filters)
            ->withCount('replies')
            ->with(['creator', 'channel'])
            ->latest()
            ->get();

        if ($request->wantsJson()) return $threads;

        return view('threads.index', compact('threads'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(StoreThreadRequest $request)
    {
        $attributes =[...$request->validated(), 'user_id' => auth()->id()];

        $thread = Thread::query()->create($attributes);

        return to_route('threads.show', ['channel' => $thread->channel, 'thread' => $thread])
            ->with('success', 'Post was created!');
    }

    public function show(Channel $channel, Thread $thread)
    {
        $replies = $thread->replies()->with('owner')->paginate(10);

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

    public function destroy(Thread $thread)
    {
        //
    }
}
