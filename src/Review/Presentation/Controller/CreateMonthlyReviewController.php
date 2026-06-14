<?php

declare(strict_types=1);

namespace App\Review\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Application\DTO\CreateMonthlyReviewInput;
use App\Review\Application\UseCase\CreateMonthlyReviewUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/reviews/monthly/create',
)]
final class CreateMonthlyReviewController extends AbstractController
{
    public function __construct(
        private readonly CreateMonthlyReviewUseCase $createMonthlyReviewUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'monthly_review_create',
        methods: ['GET'],
    )]
    public function form(): Response
    {
        return $this->render(
            'review/monthly/create.html.twig',
        );
    }

    #[Route(
        path: '',
        name: 'monthly_review_store',
        methods: ['POST'],
    )]
    public function store(
        Request $request,
    ): RedirectResponse {
        $user = $this->getUser();

        $this->createMonthlyReviewUseCase->execute(
            new CreateMonthlyReviewInput(
                userId: UserId::fromString($user->getUserIdentifier()),
                month: new \DateTimeImmutable(
                    $request->request->get(
                        'month',
                    ),
                ),
                majorAchievements: $request->request->get(
                    'majorAchievements',
                ),
                goalProgress: $request->request->get(
                    'goalProgress',
                ),
                majorChallenges: $request->request->get(
                    'majorChallenges',
                ),
                lessonsLearned: $request->request->get(
                    'lessonsLearned',
                ),
                nextMonthFocus: $request->request->get(
                    'nextMonthFocus',
                ),
            ),
        );

        return $this->redirectToRoute(
            'monthly_review_list',
        );
    }
}
