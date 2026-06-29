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
    #[Route(
        path: '',
        name: 'task_list',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {

        return $this->render(
            'task/list.html.twig'
        );
    }
}
