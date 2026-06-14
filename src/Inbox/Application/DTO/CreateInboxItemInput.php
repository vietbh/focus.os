<?php

declare(strict_types=1);

namespace App\Inbox\Application\DTO;

use App\Identity\Domain\ValueObject\UserId;

final readonly class CreateInboxItemInput
{
    public function __construct(
        public UserId $userId,
        public string $content,
    ) {
    }
}
