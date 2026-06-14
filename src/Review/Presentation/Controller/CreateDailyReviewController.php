<?php

declare(strict_types=1);

namespace App\Review\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Application\DTO\CreateDailyReviewInput;
use App\Review\Application\UseCase\CreateDailyReviewUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/reviews/daily/create',
)]
final class CreateDailyReviewController extends AbstractController
{
    public function __construct(
        private readonly CreateDailyReviewUseCase $createDailyReviewUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'daily_review_create',
        methods: ['GET'],
    )]
    public function form(): Response
    {
        return $this->render(
            'review/daily/create.html.twig',
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

        $this->createDailyReviewUseCase->execute(
            new CreateDailyReviewInput(
                userId: UserId::fromString($user->getUserIdentifier()),
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

        return $this->redirectToRoute(
            'daily_review_list',
        );
    }
}
