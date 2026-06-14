<?php

declare(strict_types=1);

namespace App\Review\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Application\UseCase\GetMonthlyReviewDetailUseCase;
use App\Review\Domain\ValueObject\MonthlyReviewId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/reviews/monthly/{monthlyReviewId}',
)]
final class MonthlyReviewDetailController extends AbstractController
{
    public function __construct(
        private readonly GetMonthlyReviewDetailUseCase $getMonthlyReviewDetailUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'monthly_review_detail',
        methods: ['GET'],
    )]
    public function __invoke(
        string $monthlyReviewId,
    ): Response {
        $user = $this->getUser();

        $review = $this->getMonthlyReviewDetailUseCase
            ->execute(
                UserId::fromString(
                    $user->getUserIdentifier()
                ),
                MonthlyReviewId::fromString(
                    $monthlyReviewId,
                ),
            );

        if ($review === null) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'review/monthly/detail.html.twig',
            [
                'review' => $review,
            ],
        );
    }
}
