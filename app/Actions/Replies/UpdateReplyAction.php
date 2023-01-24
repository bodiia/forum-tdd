<?php

declare(strict_types=1);

namespace App\Actions\Replies;

use App\DTOs\Replies\UpdateReplyDto;
use App\Models\Reply;

final class UpdateReplyAction
{
    public function execute(Reply $reply, UpdateReplyDto $updateReplyDto): void
    {
        $reply->update($updateReplyDto->all());
    }
}
