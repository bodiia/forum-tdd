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
        $attributes = ['user_id' => $user->id];

        if (! ThreadSubscription::whereSubscription($user, $thread)) {
            $thread->subscriptions()->create($attributes);
        }
    }
}
