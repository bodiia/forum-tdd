<?php

declare(strict_types=1);

namespace App\DTOs\Replies;

use App\DTOs\BaseDto;
use Illuminate\Http\Request;

final class StoreReplyDto extends BaseDto
{
    public function __construct(
        public readonly string $body,
        public readonly int $user_id
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('body'),
            (int) $request->user()->id,
        );
    }
}
