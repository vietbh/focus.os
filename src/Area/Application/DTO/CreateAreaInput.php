<?php

declare(strict_types=1);

namespace App\Area\Application\DTO;

use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;

final readonly class CreateAreaInput
{
    public function __construct(
        public UserId $userId,
        public ?GoalId $goalId,
        public string $name,
    ) {
    }
}
