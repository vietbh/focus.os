<?php

declare(strict_types=1);

namespace App\Task\Domain\Repository;

use App\Area\Domain\ValueObject\AreaId;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\Entity\Task;
use App\Task\Domain\Enum\TaskStatus;
use App\Task\Domain\ValueObject\TaskId;

interface TaskRepositoryInterface
{
    public function save(
        Task $task,
    ): void;

    public function findById(
        TaskId $id,
    ): ?Task;

    /**
     * @return Task[]
     */
    public function findByUserId(
        UserId $userId,
    ): array;

    public function findOneByUserIdAndStatus(
        UserId $userId,
        TaskStatus $status,
    ): ?Task;

    public function findDoingTask(
        UserId $userId,
    ): ?Task;

    public function countByAreaId(
        AreaId $areaId,
    ): int;

    public function countActiveTasks(
        UserId $userId,
    ): int;


}
