<?php

declare(strict_types=1);

namespace App\Actions\Threads;

use App\Models\Thread;
use App\Models\User;
use App\Services\ThreadService;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Carbon;

final class MarkThreadAsReadAction
{
    public function __construct(
        private readonly Cache $cache,
        private readonly ThreadService $threadService,
    ) {
    }

    public function execute(?User $user, Thread $thread): void
    {
        if (! is_null($user)) {
            $this->cache->forever(
                $this->threadService->getCacheKeyForVisitedThread($thread, $user),
                Carbon::now()
            );
        }
    }
}
