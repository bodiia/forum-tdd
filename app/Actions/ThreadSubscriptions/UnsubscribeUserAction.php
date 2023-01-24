<?php

declare(strict_types=1);

namespace App\Actions\ThreadSubscriptions;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UnsubscribeUserAction
{
    public function execute(User $user, Thread $thread): void
    {
        if (! $subscription = $thread->newQuery()->getSubscription($user)) {
            throw new ModelNotFoundException();
        }

        $subscription->delete();
    }
}
