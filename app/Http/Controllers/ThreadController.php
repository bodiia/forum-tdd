<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThreadRequest;
use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $threads = Thread::query()->with(['creator', 'channel'])->latest()->get();

        return view('threads.index', compact('threads'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(StoreThreadRequest $request)
    {
        $attributes = $request->validated();
        $attributes['user_id'] = auth()->id();

        $thread = Thread::query()->create($attributes);

        return to_route('threads.show', ['channel' => $thread->channel, 'thread' => $thread])
            ->with('success', 'Post was created!');
    }

    public function show(Channel $channel, Thread $thread)
    {
        $thread->load([
            'replies',
            'replies.owner',
        ]);

        return view('threads.show', compact('thread'));
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
