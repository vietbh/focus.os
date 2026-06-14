<?php

declare(strict_types=1);

namespace App\Review\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\Entity\WeeklyReview;
use App\Review\Domain\Repository\WeeklyReviewRepositoryInterface;
use App\Review\Domain\ValueObject\WeeklyReviewId;

final readonly class GetWeeklyReviewDetailUseCase
{
    public function __construct(
        private WeeklyReviewRepositoryInterface $weeklyReviews,
    ) {
    }

    public function execute(
        UserId $userId,
        WeeklyReviewId $weeklyReviewId,
    ): ?WeeklyReview {
        $weeklyReview = $this->weeklyReviews
            ->findById(
                $weeklyReviewId,
            );

        if ($weeklyReview === null) {
            return null;
        }

        if (
            !$weeklyReview->ownedBy(
                $userId,
            )
        ) {
            return null;
        }

        return $weeklyReview;
    }
}
