<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Area\Application\UseCase\GetAreaListUseCase;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Application\UseCase\GetTaskDetailUseCase;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/tasks/{taskId}/edit',
)]
final class EditTaskController extends AbstractController
{
    public function __construct(
        private readonly GetTaskDetailUseCase $getTaskDetailUseCase,
        private readonly GetAreaListUseCase $getAreaListUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'task_edit',
        methods: ['GET'],
    )]
    public function __invoke(
        string $taskId,
    ): Response {
        $user = $this->getUser();

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
            'task/edit.html.twig',
            [
                'task' => $task,
                'areas' => $this->getAreaListUseCase->execute(
                    $user->getUserIdentifier(),
                ),
            ],
        );
    }
}
