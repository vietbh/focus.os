<?php

declare(strict_types=1);

namespace App\Goal\Presentation\Controller;

use App\Goal\Application\DTO\UpdateGoalInput;
use App\Goal\Application\UseCase\UpdateGoalUseCase;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/goals/{goalId}/edit',
)]
final class UpdateGoalController extends AbstractController
{
    public function __construct(
        private readonly UpdateGoalUseCase $updateGoalUseCase,
    ) {
    }

    /**
     * @throws \Exception
     */
    #[Route(
        path: '',
        name: 'goal_update',
        methods: ['POST'],
    )]
    public function __invoke(
        string $goalId,
        Request $request,
    ): RedirectResponse {
        $user = $this->getUser();

        $targetDate = $request->request->get(
            'targetDate',
        );

        $this->updateGoalUseCase->execute(
            UserId::fromString($user->getUserIdentifier()),
            new UpdateGoalInput(
                goalId: GoalId::fromString(
                    $goalId,
                ),
                title: $request->request->get(
                    'title',
                ),
                description: $request->request->get(
                    'description',
                ),
                targetDate: $targetDate
                    ? new \DateTimeImmutable(
                        $targetDate,
                    )
                    : null,
            ),
        );

        return $this->redirectToRoute(
            'goal_detail',
            [
                'goalId' => $goalId,
            ],
        );
    }
}
