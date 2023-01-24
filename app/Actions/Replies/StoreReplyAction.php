<?php

declare(strict_types=1);

namespace App\Actions\Replies;

use App\DTOs\Replies\StoreReplyDto;
use App\Models\Reply;
use App\Models\Thread;
use App\Notifications\NewReplyCreated;

final class StoreReplyAction
{
    public function execute(Thread $thread, StoreReplyDto $dto): void
    {
        /** @var Reply $reply */
        $reply = $thread->replies()->make([
            'body' => $dto->body,
        ]);

        $reply->owner()->associate($dto->user_id);

        if ($reply->save()) {
            $thread->newQuery()->increment('replies_count');
        }

        $thread->subscriptions->notifyAll(new NewReplyCreated($thread, $reply), request()->user());
    }
}
