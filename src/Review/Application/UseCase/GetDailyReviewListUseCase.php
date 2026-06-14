<?php

declare(strict_types=1);

namespace App\Review\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\Repository\DailyReviewRepositoryInterface;

final readonly class GetDailyReviewListUseCase
{
    public function __construct(
        private DailyReviewRepositoryInterface $dailyReviews,
    ) {
    }

    public function execute(
        UserId $userId,
    ): array {
        return $this->dailyReviews->findByUserId(
            $userId,
        );
    }
}
