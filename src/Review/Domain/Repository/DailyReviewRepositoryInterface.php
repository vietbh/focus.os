<?php

declare(strict_types=1);

namespace App\Review\Domain\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\Entity\DailyReview;
use App\Review\Domain\ValueObject\DailyReviewId;

interface DailyReviewRepositoryInterface
{
    public function save(
        DailyReview $dailyReview,
    ): void;

    public function findById(
        DailyReviewId $id,
    ): ?DailyReview;

    /**
     * @return DailyReview[]
     */
    public function findByUserId(
        UserId $userId,
    ): array;

    public function findByDate(
        UserId $userId,
        \DateTimeImmutable $reviewDate,
    ): ?DailyReview;

    public function hasReviewForDate(
        UserId $userId,
        \DateTimeImmutable $date,
    ): bool;


}
