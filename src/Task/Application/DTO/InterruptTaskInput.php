<?php

declare(strict_types=1);

namespace App\Task\Application\DTO;

use App\Area\Domain\ValueObject\AreaId;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\ValueObject\TaskId;

final readonly class InterruptTaskInput
{
    public function __construct(
        public TaskId $taskId,
        public UserId $userId,
    ) {
    }
}
