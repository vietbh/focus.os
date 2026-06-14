<?php

declare(strict_types=1);

namespace App\Review\Application\DTO;

use App\Identity\Domain\ValueObject\UserId;

final readonly class CreateWeeklyReviewInput
{
    public function __construct(
        public UserId $userId,
        public \DateTimeImmutable $weekStartDate,
        public string $achievements,
        public string $lessonsLearned,
        public string $improvements,
        public string $nextWeekFocus,
    ) {
    }
}
