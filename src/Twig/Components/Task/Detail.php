<?php

namespace App\Twig\Components\Task;

use App\Identity\Domain\ValueObject\UserId;
use App\Task\Application\DTO\CompleteTaskInput;
use App\Task\Application\DTO\InterruptTaskInput;
use App\Task\Application\DTO\ResumeTaskInput;
use App\Task\Application\DTO\StartTaskInput;
use App\Task\Application\UseCase\CompleteTaskUseCase;
use App\Task\Application\UseCase\InterruptTaskUseCase;
use App\Task\Application\UseCase\ResumeTaskUseCase;
use App\Task\Application\UseCase\StartTaskUseCase;
use App\Task\Domain\Repository\TaskRepositoryInterface;
use App\Task\Domain\Repository\TaskStatusHistoryRepositoryInterface;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
final class Detail extends AbstractController
{
    use DefaultActionTrait;

    public function __construct(
        private readonly TaskStatusHistoryRepositoryInterface $histories,
        private readonly TaskRepositoryInterface              $repository,
        private readonly StartTaskUseCase                     $startTaskUseCase, private readonly CompleteTaskUseCase $completeTaskUseCase, private readonly InterruptTaskUseCase $interruptTaskUseCase, private readonly ResumeTaskUseCase $resumeTaskUseCase,

    )
    {
    }

    #[LiveProp]
    public string $taskId;

    #[ExposeInTemplate]
    public function task()
    {
        return $this->repository->findById(TaskId::fromString($this->taskId));
    }

    #[ExposeInTemplate]
    public function histories()
    {
        return $this->histories->findByTaskId(
            TaskId::fromString($this->taskId),
        );
    }

    #[LiveAction]
    public function completeTask(): void
    {
        $this->completeTaskUseCase->execute(
            new CompleteTaskInput(
                TaskId::fromString(
                    $this->taskId,
                ),
                UserId::fromString(
                    $this->getUser()->getUserIdentifier()),
            )
        );

    }

    #[LiveAction]
    public function startTask(): void
    {
        $this->startTaskUseCase->execute(
            new StartTaskInput(
                taskId: TaskId::fromString($this->taskId),
                userId: UserId::fromString($this->getUser()->getUserIdentifier())
            ),
        );

    }

    #[LiveAction]
    public function interruptTask(): void
    {
        $this->interruptTaskUseCase->execute(
            new InterruptTaskInput(
                TaskId::fromString(
                    $this->taskId,
                ),
                UserId::fromString(
                    $this->getUser()->getUserIdentifier())
            )
        );
    }

    #[LiveAction]
    public function resumeTask(): void
    {
        $this->resumeTaskUseCase->execute(
            new ResumeTaskInput(
                TaskId::fromString(
                    $this->taskId,
                ),
                UserId::fromString($this->getUser()->getUserIdentifier()),
            )
        );
    }
}
