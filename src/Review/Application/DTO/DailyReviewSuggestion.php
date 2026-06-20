<?php

declare(strict_types=1);

namespace App\Review\Application\DTO;

final readonly class DailyReviewSuggestion
{
    public function __construct(
        public string $completedWork,
        public string $wins,
        public string $blockers,
        public string $focusTomorrow,
    ) {
    }
}
