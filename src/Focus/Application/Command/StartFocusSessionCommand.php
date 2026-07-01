<?php

declare(strict_types=1);

namespace App\Focus\Application\Command;

use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\ValueObject\TaskId;

final readonly class StartFocusSessionCommand
{
    public function __construct(
        public UserId $userId,
        public TaskId $taskId,
        public ?\DateTimeImmutable $startedAt = null,
    ) {
    }
}
