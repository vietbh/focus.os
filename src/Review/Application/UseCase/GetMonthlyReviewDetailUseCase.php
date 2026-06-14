<?php

declare(strict_types=1);

namespace App\Review\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\Entity\MonthlyReview;
use App\Review\Domain\Repository\MonthlyReviewRepositoryInterface;
use App\Review\Domain\ValueObject\MonthlyReviewId;

final readonly class GetMonthlyReviewDetailUseCase
{
    public function __construct(
        private MonthlyReviewRepositoryInterface $monthlyReviews,
    ) {
    }

    public function execute(
        UserId $userId,
        MonthlyReviewId $monthlyReviewId,
    ): ?MonthlyReview {
        $monthlyReview = $this->monthlyReviews
            ->findById(
                $monthlyReviewId,
            );

        if ($monthlyReview === null) {
            return null;
        }

        if (
            !$monthlyReview->ownedBy(
                $userId,
            )
        ) {
            return null;
        }

        return $monthlyReview;
    }
}
