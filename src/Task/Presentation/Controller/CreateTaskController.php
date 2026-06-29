<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Area\Application\UseCase\GetAreaListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/tasks/create',
)]
final class CreateTaskController extends AbstractController
{

    #[Route(
        path: '',
        name: 'task_create',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        return $this->render(
            'task/create.html.twig',
            [

            ],
        );
    }
}
