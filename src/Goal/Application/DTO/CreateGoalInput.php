<?php

declare(strict_types=1);

namespace App\Goal\Application\DTO;

use App\Identity\Domain\ValueObject\UserId;

final readonly class CreateGoalInput
{
    public function __construct(
        public UserId $userId,
        public string $title,
        public ?string $description,
        public ?\DateTimeImmutable $targetDate,
    ) {
    }
}
