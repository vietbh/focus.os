<?php

declare(strict_types=1);

namespace App\Task\Application\DTO;

use App\Area\Domain\ValueObject\AreaId;
use App\Identity\Domain\ValueObject\UserId;

final readonly class CreateTaskInput
{
    public function __construct(
        public UserId $userId,
        public AreaId $areaId,
        public string $title,
        public ?string $description,
        public string $nextAction,
        public int $estimatedMinutes,
    ) {
    }
}
