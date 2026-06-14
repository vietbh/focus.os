<?php

declare(strict_types=1);

namespace App\Task\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\SharedKernel\Domain\Service\ClockInterface;
use App\SharedKernel\Infrastructure\Persistence\DoctrineTransactionManager;
use App\Task\Application\DTO\UpdateTaskInput;
use App\Task\Domain\Exception\TaskNotFoundException;
use App\Task\Domain\Repository\TaskRepositoryInterface;
use App\Task\Domain\ValueObject\NextAction;

final readonly class UpdateTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $tasks,
        private ClockInterface $clock,
        private DoctrineTransactionManager $transaction,

    ) {
    }

    public function execute(
        UpdateTaskInput $input,
        UserId $userId,
    ): void {

        $task = $this->tasks->findById(
            $input->taskId,
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
        $task->update(
            areaId: $input->areaId,
            title: $input->title,
            description: $input->description,
            nextAction: NextAction::fromString(
                $input->nextAction,
            ),
            estimatedMinutes: $input->estimatedMinutes,
            updatedAt: $this->clock->now(),
        );

        $this->transaction->wrap(function () use ($task): void {
            $this->tasks->save(
                $task,
            );
        });

    }
}
