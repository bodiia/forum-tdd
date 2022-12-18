<?php

declare(strict_types=1);

namespace App\DTOs\Replies;

use App\DTOs\BaseDto;

final class UpdateReplyDto extends BaseDto
{
    public function __construct(
        public readonly string $body
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self($data['body']);
    }
}
