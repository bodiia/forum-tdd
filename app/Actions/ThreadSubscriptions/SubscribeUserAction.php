<?php

declare(strict_types=1);

namespace App\Actions\ThreadSubscriptions;

use App\Models\Thread;
use App\Models\ThreadSubscription;
use App\Models\User;

final class SubscribeUserAction
{
    public static function execute(User $user, Thread $thread): void
    {
        if (! $thread->newQuery()->getSubscription($user)) {
            /** @var ThreadSubscription $subscription */
            $subscription = $thread->subscriptions()->make();
            $subscription->subscriber()->associate($user);
            $subscription->save();
        }
    }
}
