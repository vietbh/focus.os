<?php

declare(strict_types=1);

namespace App\Review\Domain\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\Entity\WeeklyReview;
use App\Review\Domain\ValueObject\WeeklyReviewId;

interface WeeklyReviewRepositoryInterface
{
    public function save(
        WeeklyReview $weeklyReview,
    ): void;

    public function findById(
        WeeklyReviewId $id,
    ): ?WeeklyReview;

    /**
     * @return WeeklyReview[]
     */
    public function findByUserId(
        UserId $userId,
    ): array;

    public function findByWeekStartDate(
        UserId $userId,
        \DateTimeImmutable $weekStartDate,
    ): ?WeeklyReview;
}
