<?php

declare(strict_types=1);

namespace App\Actions\ThreadSubscriptions;

use App\Models\Thread;
use App\Models\User;

final class SubscribeUserAction
{
    public static function execute(User $user, Thread $thread): void
    {
        $attributes = ['user_id' => $user->id];

        if (! $thread->newQuery()->getSubscription($user)) {
            $thread->subscriptions()->create($attributes);
        }
    }
}
