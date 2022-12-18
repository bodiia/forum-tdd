<?php

declare(strict_types=1);

namespace App\Actions\ThreadSubscriptions;

use App\Models\Thread;
use App\Models\ThreadSubscription;
use App\Models\User;

final class UnsubscribeUserAction
{
    public static function execute(User $user, Thread $thread): void
    {
        if (ThreadSubscription::whereSubscription($user, $thread)) {
            $thread->subscriptions()->whereBelongsTo($user, 'subscriber')->delete();
        }
    }
}
