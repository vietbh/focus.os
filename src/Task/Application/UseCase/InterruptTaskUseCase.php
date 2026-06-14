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

final readonly class InterruptTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $tasks,
        private TaskStatusHistoryRepositoryInterface $histories,
        private ClockInterface $clock,
        private DoctrineTransactionManager $transaction,
    ) {
    }

    public function execute(
        TaskId $taskId,
        UserId $userId,
    ): void {
        $task = $this->tasks->findById(
            $taskId,
        );

        if ($task === null) {
            throw new TaskNotFoundException();
        }
        if (
            !$task->ownedBy(
                $userId,
            )
        ) {
            throw new TaskNotFoundException();
        }
        $task->interrupt(
            $this->clock->now(),
        );

        $history = TaskStatusHistory::create(
            id: Uuid::v7()->toRfc4122(),
            taskId: $task->id(),
            fromStatus: TaskStatus::DOING,
            toStatus: TaskStatus::INTERRUPTED,
            occurredAt: $this->clock->now(),
        );

        $this->transaction->wrap(function () use ($task, $history): void {
            $this->tasks->save(
                $task,
            );

            $this->histories->save(
                $history,
            );
        });

    }
}
