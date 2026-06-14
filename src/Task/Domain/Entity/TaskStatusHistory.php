<?php

declare(strict_types=1);

namespace App\Task\Domain\Entity;

use App\Task\Domain\Enum\TaskStatus;
use App\Task\Domain\ValueObject\TaskId;

final class TaskStatusHistory
{
    public function __construct(
        private string $id,
        private TaskId $taskId,
        private TaskStatus $fromStatus,
        private TaskStatus $toStatus,
        private \DateTimeImmutable $occurredAt,
    ) {
    }

    public static function create(
        string $id,
        TaskId $taskId,
        TaskStatus $fromStatus,
        TaskStatus $toStatus,
        \DateTimeImmutable $occurredAt,
    ): self {
        return new self(
            $id,
            $taskId,
            $fromStatus,
            $toStatus,
            $occurredAt,
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function taskId(): TaskId
    {
        return $this->taskId;
    }

    public function fromStatus(): TaskStatus
    {
        return $this->fromStatus;
    }

    public function toStatus(): TaskStatus
    {
        return $this->toStatus;
    }

    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
