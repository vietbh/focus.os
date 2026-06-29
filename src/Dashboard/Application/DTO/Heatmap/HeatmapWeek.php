<?php

declare(strict_types=1);

namespace App\Dashboard\Application\DTO\Heatmap;

/**
 * @phpstan-type Days list<HeatmapDay>
 */
final readonly class HeatmapWeek
{
    /**
     * @param list<HeatmapDay> $days
     */
    public function __construct(
        public array $days,
    ) {
    }
}
