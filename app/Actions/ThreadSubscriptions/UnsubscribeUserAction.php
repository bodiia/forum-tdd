<?php

declare(strict_types=1);

namespace App\Actions\ThreadSubscriptions;

use App\Models\Thread;
use App\Models\ThreadSubscription;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UnsubscribeUserAction
{
    public static function execute(User $user, Thread $thread): void
    {
        if (! $subscription = ThreadSubscription::whereSubscription($user, $thread)) {
            throw new ModelNotFoundException();
        }

        $subscription->delete();
    }
}
