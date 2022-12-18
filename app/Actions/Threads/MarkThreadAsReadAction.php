<?php

declare(strict_types=1);

namespace App\Actions\Threads;

use App\Models\Thread;
use App\Models\User;
use App\Services\ThreadService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

final class MarkThreadAsReadAction
{
    public static function execute(?User $user, Thread $thread, ThreadService $service): void
    {
        if (! is_null($user)) {
            Cache::forever($service->getCacheKeyForVisitedThread($thread, $user), Carbon::now());
        }
    }
}
