<?php

declare(strict_types=1);

namespace App\Goal\Presentation\Controller;

use App\Goal\Application\UseCase\GetGoalListUseCase;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/goals',
)]
final class GoalController extends AbstractController
{


    #[Route(
        path: '',
        name: 'goal_list',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        return $this->render(
            'goal/list.html.twig',
        );
    }
}
