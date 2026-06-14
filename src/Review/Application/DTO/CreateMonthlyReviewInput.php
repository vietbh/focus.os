<?php

declare(strict_types=1);

namespace App\Review\Application\DTO;

use App\Identity\Domain\ValueObject\UserId;

final readonly class CreateMonthlyReviewInput
{
    public function __construct(
        public UserId $userId,
        public \DateTimeImmutable $month,
        public string $majorAchievements,
        public string $goalProgress,
        public string $majorChallenges,
        public string $lessonsLearned,
        public string $nextMonthFocus,
    ) {
    }
}
