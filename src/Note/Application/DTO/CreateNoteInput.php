<?php

declare(strict_types=1);

namespace App\Note\Application\DTO;

use App\Identity\Domain\ValueObject\UserId;

final readonly class CreateNoteInput
{
    public function __construct(
        public UserId $userId,
        public string $title,
        public ?string $content,
    ) {
    }
}
