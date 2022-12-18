<?php

declare(strict_types=1);

namespace App\DTOs\Threads;

use App\DTOs\BaseDto;
use Illuminate\Http\Request;

final class StoreThreadDto extends BaseDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $body,
        public readonly int $channel_id,
        public readonly int $user_id
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('title'),
            $request->get('body'),
            (int) $request->get('channel_id'),
            (int) $request->user()->id
        );
    }
}
