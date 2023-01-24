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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThreadController extends Controller
{
    public function __construct(
        private readonly MarkThreadAsReadAction $markThreadAsReadAction,
        private readonly DeleteThreadAction $deleteThreadAction,
        private readonly StoreThreadAction $storeThreadAction,
    ) {
    }

    public function index(Request $request, ThreadsFilter $filters): View|JsonResponse
    {
        $threads = Thread::withFilters($filters)
            ->latest()
            ->get();

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
        $thread = $this->storeThreadAction->execute(
            StoreThreadDto::fromRequest($request)
        );

        return to_route('threads.show', [
            'channel' => $thread->channel,
            'thread' => $thread,
        ])->with('success', __('flash.thread.created'));
    }

    public function show(Channel $channel, Thread $thread, Request $request): View
    {
        $replies = $thread->replies()->paginate();

        $this->markThreadAsReadAction->execute(
            $request->user(),
            $thread
        );

        return view('threads.show', compact('thread', 'replies'));
    }

    public function destroy(Channel $channel, Thread $thread): RedirectResponse
    {
        $this->authorize('delete', $thread);

        $this->deleteThreadAction->execute($thread);

        return to_route('threads.index')
            ->with('success', __('flash.thread.deleted'));
    }
}
