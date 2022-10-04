<?php

namespace App\Policies;

use App\Models\ThreadSubscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadSubscriptionPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, ThreadSubscription $subscription): bool
    {
        return $subscription->subscriber()->is($user);
    }
}
