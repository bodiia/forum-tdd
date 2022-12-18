<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

final class ThreadService
{
    public function hasUpdatesFor(Thread $thread, User $user): bool
    {
        return $thread->updated_at > Cache::get($this->getCacheKeyForVisitedThread($thread, $user));
    }

    public function getCacheKeyForVisitedThread(Thread $thread, User $user): string
    {
        return sprintf('users.%s.threads.%s', $user->id, $thread->id);
    }
}
