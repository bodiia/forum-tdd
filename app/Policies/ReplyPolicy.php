<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Reply $reply)
    {
        //
    }

    public function delete(User $user, Reply $reply)
    {
        return $reply->owner()->is($user);
    }
}
