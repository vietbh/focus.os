<?php

declare(strict_types=1);

namespace App\Review\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\Repository\WeeklyReviewRepositoryInterface;

final readonly class GetWeeklyReviewListUseCase
{
    public function __construct(
        private WeeklyReviewRepositoryInterface $weeklyReviews,
    ) {
    }

    public function execute(
        UserId $userId,
    ): array {
        return $this->weeklyReviews
            ->findByUserId(
                $userId,
            );
    }
}
