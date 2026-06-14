<?php

declare(strict_types=1);

namespace App\Review\Domain\Entity;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\ValueObject\WeeklyReviewId;

final class WeeklyReview
{
    public function __construct(
        private WeeklyReviewId $id,
        private UserId $userId,
        private \DateTimeImmutable $weekStartDate,
        private string $achievements,
        private string $lessonsLearned,
        private string $improvements,
        private string $nextWeekFocus,
        private \DateTimeImmutable $createdAt,
    ) {
    }

    public static function create(
        WeeklyReviewId $id,
        UserId $userId,
        \DateTimeImmutable $weekStartDate,
        string $achievements,
        string $lessonsLearned,
        string $improvements,
        string $nextWeekFocus,
        \DateTimeImmutable $createdAt,
    ): self {
        return new self(
            id: $id,
            userId: $userId,
            weekStartDate: $weekStartDate,
            achievements: trim(
                $achievements,
            ),
            lessonsLearned: trim(
                $lessonsLearned,
            ),
            improvements: trim(
                $improvements,
            ),
            nextWeekFocus: trim(
                $nextWeekFocus,
            ),
            createdAt: $createdAt,
        );
    }

    public function id(): WeeklyReviewId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function weekStartDate(): \DateTimeImmutable
    {
        return $this->weekStartDate;
    }

    public function achievements(): string
    {
        return $this->achievements;
    }

    public function lessonsLearned(): string
    {
        return $this->lessonsLearned;
    }

    public function improvements(): string
    {
        return $this->improvements;
    }

    public function nextWeekFocus(): string
    {
        return $this->nextWeekFocus;
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
