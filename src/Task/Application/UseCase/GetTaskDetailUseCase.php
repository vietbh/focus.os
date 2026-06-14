<?php

declare(strict_types=1);

namespace App\Task\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\Entity\Task;
use App\Task\Domain\Repository\TaskRepositoryInterface;
use App\Task\Domain\ValueObject\TaskId;

final readonly class GetTaskDetailUseCase
{
    public function __construct(
        private TaskRepositoryInterface $tasks,
    ) {
    }

    public function execute(
        TaskId $taskId,
        UserId $userId,
    ): ?Task {
        $task = $this->tasks->findById(
            $taskId,
        );

        if ($task === null) {
            return null;
        }

        if (
            !$task->ownedBy(
                $userId,
            )
        ) {
            return null;
        }

        return $task;
    }
}
