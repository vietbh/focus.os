<?php

declare(strict_types=1);

namespace App\Goal\Presentation\Controller;

use App\Goal\Application\DTO\CreateGoalInput;
use App\Goal\Application\UseCase\CreateGoalUseCase;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/goals/create',
)]
final class CreateGoalController extends AbstractController
{

    #[Route(
        path: '',
        name: 'goal_create',
        methods: ['GET'],
    )]
    public function create(): Response
    {
        return $this->render(
            'goal/create.html.twig',
            [
                'goal' => null,
            ],
        );
    }

}
