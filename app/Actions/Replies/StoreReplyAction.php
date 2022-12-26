<?php

declare(strict_types=1);

namespace App\Actions\Replies;

use App\DTOs\Replies\StoreReplyDto;
use App\Models\Reply;
use App\Models\Thread;
use App\Notifications\CreatedReply;

final class StoreReplyAction
{
    public static function execute(Thread $thread, StoreReplyDto $dto): void
    {
        /** @var Reply $reply */
        $reply = $thread->replies()->make([
            'body' => $dto->body,
        ]);

        $reply->owner()->associate($dto->user_id);

        if ($reply->save()) {
            $thread->newQuery()->increment('replies_count');
        }

        $thread->subscriptions->notifyAll(
            notification: new CreatedReply($thread, $reply),
            currentUser: request()->user()
        );
    }
}
