<?php

declare(strict_types=1);

namespace App\Focus\Application\Analytics\DTO;

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
