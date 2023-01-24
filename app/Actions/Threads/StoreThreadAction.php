<?php

declare(strict_types=1);

namespace App\Actions\Threads;

use App\DTOs\Threads\StoreThreadDto;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Model;

final class StoreThreadAction
{
    public function execute(StoreThreadDto $dto): Thread|Model
    {
        /** @var Thread $thread */
        $thread = Thread::query()->make([
            'title' => $dto->title,
            'body' => $dto->body,
        ]);

        $thread->channel()->associate($dto->channel_id);
        $thread->creator()->associate($dto->user_id);

        $thread->save();

        return $thread;
    }
}
