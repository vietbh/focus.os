<?php

namespace App\Dashboard\Application\DTO;

use App\Dashboard\Application\DTO\Heatmap\Heatmap;

final readonly class DashboardStatistics
{
    public function __construct(
        public Heatmap $heatmap,
    ) {}

    public static function empty(): self
    {
        return new self(
            heatmap: Heatmap::empty(),
        );
    }
}
