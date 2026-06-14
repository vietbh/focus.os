<?php

declare(strict_types=1);

namespace App\Task\Domain\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\Entity\TaskStatusHistory;
use App\Task\Domain\Enum\TaskStatus;
use App\Task\Domain\ValueObject\TaskId;

interface TaskStatusHistoryRepositoryInterface
{
    public function save(
        TaskStatusHistory $history,
    ): void;

    /**
     * @return TaskStatusHistory[]
     */
    public function findByTaskId(
        TaskId $taskId,
    ): array;

    public function countStatusChangedBetween(
        UserId $userId,
        TaskStatus $status,
        \DateTimeImmutable $from,
        \DateTimeImmutable $to,
    ): int;

}
