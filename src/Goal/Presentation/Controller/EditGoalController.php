<?php

declare(strict_types=1);

namespace App\Goal\Presentation\Controller;

use App\Goal\Application\UseCase\GetGoalDetailUseCase;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/goals/{goalId}/edit',
)]
final class EditGoalController extends AbstractController
{
    public function __construct(
        private readonly GetGoalDetailUseCase $getGoalDetailUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'goal_edit',
        methods: ['GET'],
    )]
    public function __invoke(
        string $goalId,
    ): Response {

        return $this->render(
            'goal/edit.html.twig',
            [
                'goalId' => $goalId,
            ],
        );
    }
}
