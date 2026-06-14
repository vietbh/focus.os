<?php

declare(strict_types=1);

namespace App\Task\Application\DTO;

use App\Area\Domain\ValueObject\AreaId;
use App\Task\Domain\ValueObject\TaskId;

final readonly class UpdateTaskInput
{
    public function __construct(
        public TaskId $taskId,
        public AreaId $areaId,
        public string $title,
        public ?string $description,
        public string $nextAction,
        public int $estimatedMinutes,
    ) {
    }
}
