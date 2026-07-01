<?php

declare(strict_types=1);

namespace App\Focus\Application\Analytics\DTO;

final readonly class HeatmapDay
{
    public function __construct(
        public \DateTimeImmutable $date,
        public int $focusMinutes,
        public int $completedTasks,
        public int $interruptCount,
        public HeatmapLevel $level,
    ) {
    }
}
