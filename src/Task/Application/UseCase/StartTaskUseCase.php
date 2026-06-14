<?php

declare(strict_types=1);

namespace App\Task\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\SharedKernel\Domain\Service\ClockInterface;
use App\SharedKernel\Infrastructure\Persistence\DoctrineTransactionManager;
use App\Task\Domain\Entity\TaskStatusHistory;
use App\Task\Domain\Enum\TaskStatus;
use App\Task\Domain\Exception\TaskNotFoundException;
use App\Task\Domain\Repository\TaskRepositoryInterface;
use App\Task\Domain\Repository\TaskStatusHistoryRepositoryInterface;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Component\Uid\Uuid;

final readonly class StartTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $tasks,
        private TaskStatusHistoryRepositoryInterface $histories,
        private ClockInterface $clock,
        private DoctrineTransactionManager $transaction
    ) {
    }

    public function execute(
        UserId $userId,
        TaskId $taskId,
    ): void {
        $task = $this->tasks->findById(
            $taskId,
        );

        if ($task === null) {
            throw new \RuntimeException(
                'Task not found.',
            );
        }

        if (
            !$task->ownedBy(
                $userId,
            )
        ) {
            throw new TaskNotFoundException();
        }

        $currentTask = $this->tasks->findDoingTask(
            $userId,
        );

        if (
            $currentTask !== null
            && !$currentTask->id()->equals(
                $task->id(),
            )
        ) {
            throw new \RuntimeException(
                'Another task is already doing.',
            );
        }

        $task->start(
            $this->clock->now(),
        );

        $history = TaskStatusHistory::create(
            id: Uuid::v7()->toRfc4122(),
            taskId: $task->id(),
            fromStatus: TaskStatus::TODO,
            toStatus: TaskStatus::DOING,
            occurredAt: $this->clock->now(),
        );

        $this->transaction->wrap(
            function () use ($task, $history): void {
                $this->tasks->save(
                    $task,
                );

                $this->histories->save(
                    $history,
                );
            },
        );
    }
}
