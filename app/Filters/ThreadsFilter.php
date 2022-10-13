<?php
declare(strict_types=1);

namespace App\Filters;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

final class ThreadsFilter extends Filter
{
    public function byUsername(string $username): Builder
    {
        $user = User::query()->where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    public function byPopularity(string $direction): Builder
    {
        return $this->builder->orderBy('replies_count', $direction);
    }

    public function byUnanswered(): Builder
    {
        return $this->builder->where('replies_count', 0);
    }
}
