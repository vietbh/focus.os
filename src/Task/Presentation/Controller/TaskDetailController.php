<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Task\Application\UseCase\GetTaskDetailUseCase;
use App\Task\Domain\Repository\TaskStatusHistoryRepositoryInterface;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/tasks/{taskId}',
)]
final class TaskDetailController extends AbstractController
{
    public function __construct(
        private readonly GetTaskDetailUseCase $getTaskDetailUseCase,
        private readonly TaskStatusHistoryRepositoryInterface $histories,
    ) {
    }

    #[Route(
        path: '',
        name: 'task_detail',
        methods: ['GET'],
    )]
    public function __invoke(
        string $taskId,
    ): Response {
        $task = $this->getTaskDetailUseCase->execute(
            TaskId::fromString(
                $taskId,
            ),
            UserId::fromString(
                $this->getUser()->getUserIdentifier())
        );

        if ($task === null) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'task/detail.html.twig',
            [
                'task' => $task,
                'histories' => $this->histories->findByTaskId(
                    $task->id(),
                ),
            ],
        );
    }
}
