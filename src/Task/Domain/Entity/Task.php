<?php

declare(strict_types=1);

namespace App\Task\Domain\Entity;

use App\Area\Domain\ValueObject\AreaId;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\Enum\TaskStatus;
use App\Task\Domain\ValueObject\NextAction;
use App\Task\Domain\ValueObject\TaskId;
use DateTimeImmutable;
use RuntimeException;

final class Task
{
    public function __construct(
        private TaskId $id,
        private UserId $userId,
        private AreaId $areaId,
        private string $title,
        private ?string $description,
        private NextAction $nextAction,
        private TaskStatus $status,
        private int $estimatedMinutes,
        private \DateTimeImmutable $createdAt,
        private \DateTimeImmutable $updatedAt,
    ) {
    }

    public static function create(
        TaskId $id,
        UserId $userId,
        AreaId $areaId,
        string $title,
        ?string $description,
        NextAction $nextAction,
        int $estimatedMinutes,
        \DateTimeImmutable $createdAt,
    ): self {
        return new self(
            $id,
            $userId,
            $areaId,
            $title,
            $description,
            $nextAction,
            TaskStatus::TODO,
            $estimatedMinutes,
            $createdAt,
            $createdAt,
        );
    }

    public function start(
        DateTimeImmutable $updatedAt,
    ): void
    {
        if ($this->status !== TaskStatus::TODO) {
            throw new RuntimeException(
                'Task can only be started from TODO status.',
            );
        }

        $this->status = TaskStatus::DOING;
        $this->updatedAt = $updatedAt;
    }

    public function interrupt(
        DateTimeImmutable $updatedAt,
    ): void
    {
        if ($this->status !== TaskStatus::DOING) {
            throw new RuntimeException(
                'Task can only be interrupted from DOING status.',
            );
        }

        $this->status = TaskStatus::INTERRUPTED;
        $this->updatedAt = $updatedAt;
    }

    public function resume(
        DateTimeImmutable $updatedAt,
    ): void
    {
        if ($this->status !== TaskStatus::INTERRUPTED) {
            throw new RuntimeException(
                'Task can only be resumed from INTERRUPTED status.',
            );
        }

        $this->status = TaskStatus::DOING;
        $this->updatedAt = $updatedAt;
    }

    public function complete(
        DateTimeImmutable $updatedAt,
    ): void
    {
        if ($this->status !== TaskStatus::DOING) {
            throw new RuntimeException(
                'Task can only be completed from DOING status.',
            );
        }

        $this->status = TaskStatus::DONE;
        $this->updatedAt = $updatedAt;
    }
    public function update(
        AreaId $areaId,
        string $title,
        ?string $description,
        NextAction $nextAction,
        int $estimatedMinutes,
        \DateTimeImmutable $updatedAt,
    ): void {
        $this->areaId = $areaId;
        $this->title = $title;
        $this->description = $description;
        $this->nextAction = $nextAction;
        $this->estimatedMinutes = $estimatedMinutes;
        $this->updatedAt = $updatedAt;
    }
    public function id(): TaskId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function areaId(): AreaId
    {
        return $this->areaId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function nextAction(): NextAction
    {
        return $this->nextAction;
    }

    public function status(): TaskStatus
    {
        return $this->status;
    }

    public function estimatedMinutes(): int
    {
        return $this->estimatedMinutes;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function ownedBy(
        UserId $userId,
    ): bool {
        return $this->userId->equals(
            $userId,
        );
    }
}
