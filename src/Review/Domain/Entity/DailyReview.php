<?php

declare(strict_types=1);

namespace App\Review\Domain\Entity;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\ValueObject\DailyReviewId;

final class DailyReview
{
    public function __construct(
        private DailyReviewId $id,
        private UserId $userId,
        private \DateTimeImmutable $reviewDate,
        private string $completedWork,
        private string $wins,
        private string $blockers,
        private string $focusTomorrow,
        private \DateTimeImmutable $createdAt,
    ) {
    }

    public static function create(
        DailyReviewId $id,
        UserId $userId,
        \DateTimeImmutable $reviewDate,
        string $completedWork,
        string $wins,
        string $blockers,
        string $focusTomorrow,
        \DateTimeImmutable $createdAt,
    ): self {
        return new self(
            id: $id,
            userId: $userId,
            reviewDate: $reviewDate,
            completedWork: trim($completedWork),
            wins: trim($wins),
            blockers: trim($blockers),
            focusTomorrow: trim($focusTomorrow),
            createdAt: $createdAt,
        );
    }

    public function id(): DailyReviewId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function reviewDate(): \DateTimeImmutable
    {
        return $this->reviewDate;
    }

    public function completedWork(): string
    {
        return $this->completedWork;
    }

    public function wins(): string
    {
        return $this->wins;
    }

    public function blockers(): string
    {
        return $this->blockers;
    }

    public function focusTomorrow(): string
    {
        return $this->focusTomorrow;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
