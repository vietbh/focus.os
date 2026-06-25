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

    #[Route(
        path: '',
        name: 'task_edit',
        methods: ['GET'],
    )]
    public function __invoke(
        string $taskId,
    ): Response {
        return $this->render(
            'task/edit.html.twig',
            [
                'taskId' => $taskId,
            ],
        );
    }
}
