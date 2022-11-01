<?php

declare(strict_types=1);

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;

final class ThreadSubscriptionCollection extends Collection
{
    public function notify(Notification $notification): ThreadSubscriptionCollection
    {
        return $this
            ->filter(fn ($subscription) => ! $subscription->subscriber()->is(auth()->user()))
            ->each(fn ($subscription) => $subscription->subscriber->notify($notification));
    }
}
