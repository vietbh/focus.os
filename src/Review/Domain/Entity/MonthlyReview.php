<?php

declare(strict_types=1);

namespace App\Review\Domain\Entity;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\ValueObject\MonthlyReviewId;

final class MonthlyReview
{
    public function __construct(
        private MonthlyReviewId $id,
        private UserId $userId,
        private \DateTimeImmutable $month,
        private string $majorAchievements,
        private string $goalProgress,
        private string $majorChallenges,
        private string $lessonsLearned,
        private string $nextMonthFocus,
        private \DateTimeImmutable $createdAt,
    ) {
    }

    public static function create(
        MonthlyReviewId $id,
        UserId $userId,
        \DateTimeImmutable $month,
        string $majorAchievements,
        string $goalProgress,
        string $majorChallenges,
        string $lessonsLearned,
        string $nextMonthFocus,
        \DateTimeImmutable $createdAt,
    ): self {
        return new self(
            id: $id,
            userId: $userId,
            month: $month,
            majorAchievements: trim(
                $majorAchievements,
            ),
            goalProgress: trim(
                $goalProgress,
            ),
            majorChallenges: trim(
                $majorChallenges,
            ),
            lessonsLearned: trim(
                $lessonsLearned,
            ),
            nextMonthFocus: trim(
                $nextMonthFocus,
            ),
            createdAt: $createdAt,
        );
    }

    public function id(): MonthlyReviewId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function month(): \DateTimeImmutable
    {
        return $this->month;
    }

    public function majorAchievements(): string
    {
        return $this->majorAchievements;
    }

    public function goalProgress(): string
    {
        return $this->goalProgress;
    }

    public function majorChallenges(): string
    {
        return $this->majorChallenges;
    }

    public function lessonsLearned(): string
    {
        return $this->lessonsLearned;
    }

    public function nextMonthFocus(): string
    {
        return $this->nextMonthFocus;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function ownedBy(
        UserId $userId,
    ): bool {
        return $this->userId->equals(
            $userId,
        );
    }
}
