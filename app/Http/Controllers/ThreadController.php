<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThreadRequest;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $threads = Thread::query()->with(['creator'])->latest()->get();

        return view('threads.index', compact('threads'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(StoreThreadRequest $request)
    {
        $thread = new Thread($request->validated());
        $thread->creator()->associate(auth()->user());
        $thread->save();

        return to_route('threads.show', $thread)->with('success', 'Post was created!');
    }

    public function show(Thread $thread)
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
