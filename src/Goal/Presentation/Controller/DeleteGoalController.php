<?php

declare(strict_types=1);

namespace App\Goal\Presentation\Controller;

use App\Goal\Application\UseCase\DeleteGoalUseCase;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/goals/{goalId}/delete',
)]
final class DeleteGoalController extends AbstractController
{
    public function __construct(
        private readonly DeleteGoalUseCase $deleteGoalUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'goal_delete',
        methods: ['POST'],
    )]
    public function __invoke(
        string $goalId,
    ): RedirectResponse {
        $user = $this->getUser();

        $this->deleteGoalUseCase->execute(
            UserId::fromString($user->getUserIdentifier()),
            GoalId::fromString(
                $goalId,
            ),
        );

        return $this->redirectToRoute(
            'goal_list',
        );
    }
}
