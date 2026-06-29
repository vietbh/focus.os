<?php

namespace App\Dashboard\Application\DTO;

final readonly class HeatmapDay
{
    public function __construct(
        public \DateTimeImmutable $date,
        public int $focusMinutes,
        public int $completedTasks,
        public int $interruptCount,
        public int $level,
    ) {
    }
}
