<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;

final class ThreadSubscriptionCollection extends Collection
{
    public function notifyAll(Notification $notification, User $currentUser): ThreadSubscriptionCollection
    {
        return $this
            ->filter(fn ($subscription) => ! $subscription->subscriber()->is($currentUser))
            ->each(fn ($subscription) => $subscription->subscriber->notify($notification));
    }
}
