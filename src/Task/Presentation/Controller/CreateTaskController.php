<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Area\Application\UseCase\GetAreaListUseCase;
use App\Identity\Domain\Entity\User;
use App\Task\Application\UseCase\CreateTaskUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/tasks/create',
)]
final class CreateTaskController extends AbstractController
{
    public function __construct(
        private readonly GetAreaListUseCase $getAreaListUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'task_create',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        $user = $this->getUser();

        if ($user === null) {
            throw $this->createAccessDeniedException();
        }

        return $this->render(
            'task/create.html.twig',
            [
                'areas' => $this->getAreaListUseCase->execute(
                    $user->getUserIdentifier(),
                ),
            ],
        );
    }
}
