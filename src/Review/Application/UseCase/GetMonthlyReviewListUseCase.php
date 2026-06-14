<?php

declare(strict_types=1);

namespace App\Review\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\Repository\MonthlyReviewRepositoryInterface;

final readonly class GetMonthlyReviewListUseCase
{
    public function __construct(
        private MonthlyReviewRepositoryInterface $monthlyReviews,
    ) {
    }

    public function execute(
        UserId $userId,
    ): array {
        return $this->monthlyReviews
            ->findByUserId(
                $userId,
            );
    }
}
