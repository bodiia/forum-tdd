<?php

declare(strict_types=1);

namespace App\Actions\Threads;

use App\DTOs\Threads\StoreThreadDto;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Model;

final class StoreThreadAction
{
    public static function execute(StoreThreadDto $dto): Thread|Model
    {
        return Thread::query()->create($dto->all());
    }
}
