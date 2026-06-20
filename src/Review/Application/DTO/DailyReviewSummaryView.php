<?php

declare(strict_types=1);

namespace App\Review\Application\DTO;

final readonly class DailyReviewSummaryView
{
    public function __construct(
        public int $completedTasks,
        public int $interruptedTasks,
        public int $focusMinutes,
    ) {
    }
}
