<?php

namespace App\Filters;

use App\Models\User;

class ThreadsFilter extends Filter
{
    public function byUsername(string $username)
    {
        $user = User::query()->where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }
}
