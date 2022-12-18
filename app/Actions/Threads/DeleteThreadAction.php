<?php

declare(strict_types=1);

namespace App\Actions\Threads;

use App\Models\Thread;

final class DeleteThreadAction
{
    public static function execute(Thread $thread): void
    {
        $thread->replies->each->delete();
        $thread->subscriptions->each->delete();

        $thread->delete();
    }
}
