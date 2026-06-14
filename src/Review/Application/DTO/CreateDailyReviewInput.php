<?php

declare(strict_types=1);

namespace App\Review\Application\DTO;

use App\Identity\Domain\ValueObject\UserId;

final readonly class CreateDailyReviewInput
{
    public function __construct(
        public UserId $userId,
        public \DateTimeImmutable $reviewDate,
        public string $completedWork,
        public string $wins,
        public string $blockers,
        public string $focusTomorrow,
    ) {
    }
}
