<?php

declare(strict_types=1);

namespace App\Goal\Application\DTO;

use App\Goal\Domain\ValueObject\GoalId;

final readonly class UpdateGoalInput
{
    public function __construct(
        public GoalId $goalId,
        public string $title,
        public ?string $description,
        public ?\DateTimeImmutable $targetDate,
    ) {
    }
}
