<?php

namespace App\Http\Controllers;

use App\Actions\Threads\DeleteThreadAction;
use App\Actions\Threads\MarkThreadAsReadAction;
use App\Actions\Threads\StoreThreadAction;
use App\DTOs\Threads\StoreThreadDto;
use App\Filters\ThreadsFilter;
use App\Http\Requests\ThreadRequest;
use App\Models\Channel;
use App\Models\Thread;
use App\Services\ThreadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class ThreadController extends Controller
{
    public function __construct(private readonly ThreadService $threadService)
    {
    }

    public function index(Request $request, ThreadsFilter $filters): View|JsonResponse
    {
        $threads = Thread::withFilters($filters)->latest()->get();

        if ($request->wantsJson()) {
            return Response::json($threads);
        }

        return view('threads.index', compact('threads'));
    }

    public function create(): View
    {
        return view('threads.create');
    }

    public function store(ThreadRequest $request): RedirectResponse
    {
        $thread = StoreThreadAction::execute(StoreThreadDto::fromRequest($request));

        return Redirect::route('threads.show', ['channel' => $thread->channel, 'thread' => $thread])
            ->with('success', __('flash.thread.created'));
    }

    public function show(Channel $channel, Thread $thread, Request $request): View
    {
        $replies = $thread->replies()->paginate();

        MarkThreadAsReadAction::execute($request->user(), $thread, $this->threadService);

        return view('threads.show', compact('thread', 'replies'));
    }

    public function destroy(Channel $channel, Thread $thread): RedirectResponse
    {
        Gate::authorize('delete', $thread);

        DeleteThreadAction::execute($thread);

        return Redirect::route('threads.index')->with('success', __('flash.thread.deleted'));
    }
}
