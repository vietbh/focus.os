<?php

declare(strict_types=1);

namespace App\Review\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Application\UseCase\GetDailyReviewDetailUseCase;
use App\Review\Domain\ValueObject\DailyReviewId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/reviews/daily/{dailyReviewId}',
)]
final class DailyReviewDetailController extends AbstractController
{
    public function __construct(
        private readonly GetDailyReviewDetailUseCase $getDailyReviewDetailUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'daily_review_detail',
        methods: ['GET'],
    )]
    public function __invoke(
        string $dailyReviewId,
    ): Response {
        $user = $this->getUser();

        $review = $this->getDailyReviewDetailUseCase->execute(
            UserId::fromString($user->getUserIdentifier()),
            DailyReviewId::fromString(
                $dailyReviewId,
            ),
        );

        if ($review === null) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'review/daily/detail.html.twig',
            [
                'review' => $review,
            ],
        );
    }
}
