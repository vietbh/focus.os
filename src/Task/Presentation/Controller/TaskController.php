<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Task\Application\UseCase\GetCurrentTaskUseCase;
use App\Task\Application\UseCase\GetTaskListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/tasks',
)]
final class TaskController extends AbstractController
{
    public function __construct(
        private readonly GetCurrentTaskUseCase $getCurrentTaskUseCase,
        private readonly GetTaskListUseCase $getTaskListUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'task_list',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        $user = $this->getUser();

        if ($user === null) {
            throw $this->createAccessDeniedException();
        }

        $currentTask = $this->getCurrentTaskUseCase->execute(
            $user->getUserIdentifier(),
        );

        $tasks = $this->getTaskListUseCase->execute(
            $user->getUserIdentifier(),
        );

        return $this->render(
            'task/list.html.twig',
            [
                'currentTask' => $currentTask,
                'tasks' => $tasks,
            ],
        );
    }
}
