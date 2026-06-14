<?php

declare(strict_types=1);

namespace App\Task\Application\UseCase;

use App\SharedKernel\Domain\Service\ClockInterface;
use App\Task\Application\DTO\CreateTaskInput;
use App\Task\Domain\Entity\Task;
use App\Task\Domain\Repository\TaskRepositoryInterface;
use App\Task\Domain\ValueObject\NextAction;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Component\Uid\Uuid;

final readonly class CreateTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $tasks,
        private ClockInterface $clock,
    ) {
    }

    public function execute(
        CreateTaskInput $input,
    ): Task {

        $task = Task::create(
            id: TaskId::fromString(
                Uuid::v7()->toRfc4122(),
            ),
            userId: $input->userId,
            areaId: $input->areaId,
            title: $input->title,
            description: $input->description,
            nextAction: NextAction::fromString(
                $input->nextAction,
            ),
            estimatedMinutes: $input->estimatedMinutes,
            createdAt: $this->clock->now(),
        );
        $this->tasks->save(
            $task,
        );

        return $task;
    }
}
