<?php

declare(strict_types=1);

namespace App\Builders;

use App\Models\Thread;
use App\Models\ThreadSubscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

final class ThreadSubscriptionBuilder extends Builder
{
    public function whereSubscription(User $subscriber, Thread $thread): ?ThreadSubscription
    {
        /** @var ThreadSubscription $subscription */
        $subscription = $this
            ->whereBelongsTo($subscriber, 'subscriber')
            ->whereBelongsTo($thread)
            ->first();

        return $subscription;
    }
}
