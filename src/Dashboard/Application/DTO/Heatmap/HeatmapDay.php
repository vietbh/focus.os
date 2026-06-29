<?php

declare(strict_types=1);

namespace App\Dashboard\Application\DTO\Heatmap;

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
