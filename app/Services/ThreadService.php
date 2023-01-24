<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Contracts\Cache\Repository as Cache;

final class ThreadService
{
    public function __construct(private readonly Cache $cache)
    {
    }

    public function hasUpdatesFor(Thread $thread, User $user): bool
    {
        $cacheKey = $this->getCacheKeyForVisitedThread($thread, $user);

        return $thread->updated_at > $this->cache->get($cacheKey);
    }

    public function getCacheKeyForVisitedThread(Thread $thread, User $user): string
    {
        return sprintf('users.%s.threads.%s', $user->id, $thread->id);
    }
}
