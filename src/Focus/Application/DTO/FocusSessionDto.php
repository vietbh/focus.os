<?php

declare(strict_types=1);

namespace App\Focus\Application\DTO;

use App\Focus\Domain\Enum\FocusSessionStatus;
use App\Focus\Domain\ValueObject\FocusSessionId;
use App\Task\Domain\ValueObject\TaskId;

final readonly class FocusSessionDto
{
    public function __construct(
        public FocusSessionId $id,
        public TaskId $taskId,
        public FocusSessionStatus $status,
        public \DateTimeImmutable $startedAt,
        public ?\DateTimeImmutable $pausedAt,
        public ?\DateTimeImmutable $endedAt,
        public int $focusSeconds,
        public int $pausedSeconds,
    ) {
    }
}
