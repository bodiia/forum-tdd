<?php

declare(strict_types=1);

namespace App\Actions\Replies;

use App\Models\Reply;

final class DeleteReplyAction
{
    public function execute(Reply $reply): void
    {
        $reply->thread()->decrement('replies_count');
        $reply->delete();
    }
}
