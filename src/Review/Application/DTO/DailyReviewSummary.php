<?php

namespace App\Review\Application\DTO;

final readonly class DailyReviewSummary
{
    public function __construct(
        public int $completedTasks,
        public int $interruptedTasks,
        public int $focusMinutes,
    ) {
    }
}
