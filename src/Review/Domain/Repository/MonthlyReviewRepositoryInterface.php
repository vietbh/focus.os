<?php

declare(strict_types=1);

namespace App\Review\Domain\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\Entity\MonthlyReview;
use App\Review\Domain\ValueObject\MonthlyReviewId;

interface MonthlyReviewRepositoryInterface
{
    public function save(
        MonthlyReview $monthlyReview,
    ): void;

    public function findById(
        MonthlyReviewId $id,
    ): ?MonthlyReview;

    /**
     * @return MonthlyReview[]
     */
    public function findByUserId(
        UserId $userId,
    ): array;

    public function findByMonth(
        UserId $userId,
        \DateTimeImmutable $month,
    ): ?MonthlyReview;
}
