<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Activity;
use App\Models\Favorite;
use App\Models\Reply;
use App\Models\ThreadSubscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

final class ActivityService
{
    public function getFeedForUser(User $user, int $take = 50): Collection
    {
        $activities = Activity::query()
            ->where('user_id', $user->id)
            ->with('subject', static function (MorphTo $morph) {
                $morph->morphWith([
                    Reply::class => 'thread',
                    Favorite::class => 'favorited',
                    ThreadSubscription::class => 'thread',
                ]);
            });

        return $activities
            ->latest()
            ->take($take)
            ->get()
            ->groupBy(static function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
