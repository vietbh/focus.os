<?php

declare(strict_types=1);

namespace App\Review\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\Entity\DailyReview;
use App\Review\Domain\Repository\DailyReviewRepositoryInterface;
use App\Review\Domain\ValueObject\DailyReviewId;

final readonly class GetDailyReviewDetailUseCase
{
    public function __construct(
        private DailyReviewRepositoryInterface $dailyReviews,
    ) {
    }

    public function execute(
        UserId $userId,
        DailyReviewId $dailyReviewId,
    ): ?DailyReview {
        $dailyReview = $this->dailyReviews->findById(
            $dailyReviewId,
        );

        if ($dailyReview === null) {
            return null;
        }

        if (
            !$dailyReview->userId()->equals(
                $userId,
            )
        ) {
            return null;
        }

        return $dailyReview;
    }
}
