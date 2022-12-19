<?php

declare(strict_types=1);

namespace App\Builders;

use App\Filters\ThreadsFilter;
use App\Models\ThreadSubscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

final class ThreadBuilder extends Builder
{
    /**
     * Get the user subscription to the thread if it exists. Call only on model.
     */
    public function getSubscription(User $user): ?ThreadSubscription
    {
        return $this->getModel()
            ->subscriptions()
            ->whereBelongsTo($user, 'subscriber')
            ->first();
    }

    public function withFilters(ThreadsFilter $filters): ThreadBuilder|Builder
    {
        return $filters->apply($this);
    }
}
