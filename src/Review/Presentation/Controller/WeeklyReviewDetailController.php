<?php

declare(strict_types=1);

namespace App\Review\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Application\UseCase\GetWeeklyReviewDetailUseCase;
use App\Review\Domain\ValueObject\WeeklyReviewId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/reviews/weekly/{weeklyReviewId}',
)]
final class WeeklyReviewDetailController extends AbstractController
{
    public function __construct(
        private readonly GetWeeklyReviewDetailUseCase $getWeeklyReviewDetailUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'weekly_review_detail',
        methods: ['GET'],
    )]
    public function __invoke(
        string $weeklyReviewId,
    ): Response {
        $userId = UserId::fromString(
            $this->getUser()
                ->getUserIdentifier(),
        );

        $reviewId = WeeklyReviewId::fromString(
            $weeklyReviewId,
        );

        $review = $this->getWeeklyReviewDetailUseCase
            ->execute(
                $userId,
                $reviewId,
            );

        if ($review === null) {
            throw $this->createNotFoundException(
                'Weekly review not found.',
            );
        }

        return $this->render(
            'review/weekly/detail.html.twig',
            [
                'review' => $review,
                'reviewType' => 'weekly',
            ],
        );
    }
}
