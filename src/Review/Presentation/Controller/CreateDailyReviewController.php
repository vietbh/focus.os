<?php

declare(strict_types=1);

namespace App\Review\Presentation\Controller;

use App\Dashboard\Application\Query\DashboardQueryService;
use App\Identity\Domain\ValueObject\UserId;
use App\Review\Application\DTO\CreateDailyReviewInput;
use App\Review\Application\UseCase\CreateDailyReviewUseCase;
use App\Review\Application\UseCase\GenerateDailyReviewSuggestionUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/reviews/daily/create',
)]
final class CreateDailyReviewController extends AbstractController
{
    public function __construct(
        private readonly CreateDailyReviewUseCase $createDailyReviewUseCase,
        private readonly DashboardQueryService $dashboardQueryService,
        private readonly GenerateDailyReviewSuggestionUseCase $suggestionUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'daily_review_create',
        methods: ['GET'],
    )]
    public function form(): Response
    {
        $userId = UserId::fromString(
            $this->getUser()->getUserIdentifier(),
        );

        $snapshot = $this->dashboardQueryService
            ->getSnapshot(
                $userId,
            );
        $suggestion = $this->suggestionUseCase
            ->execute($snapshot);

        return $this->render(
            'review/daily/create.html.twig',
            [
                'today' => $snapshot->today,
                'suggestion' => $suggestion,
            ],
        );
    }

    #[Route(
        path: '',
        name: 'daily_review_store',
        methods: ['POST'],
    )]
    public function store(
        Request $request,
    ): RedirectResponse {
        $user = $this->getUser();

        try {

            $this->createDailyReviewUseCase->execute(
                new CreateDailyReviewInput(
                    userId: UserId::fromString(
                        $user->getUserIdentifier(),
                    ),
                    reviewDate: new \DateTimeImmutable(
                        $request->request->get(
                            'reviewDate',
                        ),
                    ),
                    completedWork: $request->request->get(
                        'completedWork',
                    ),
                    wins: $request->request->get(
                        'wins',
                    ),
                    blockers: $request->request->get(
                        'blockers',
                    ),
                    focusTomorrow: $request->request->get(
                        'focusTomorrow',
                    ),
                ),
            );

            $this->addFlash(
                'success',
                'Daily review completed.',
            );

        } catch (\Throwable $exception) {

            $this->addFlash(
                'error',
                $exception->getMessage(),
            );

            return $this->redirectToRoute(
                'daily_review_create',
            );
        }

        return $this->redirectToRoute(
            'daily_review_list',
        );
    }
}
