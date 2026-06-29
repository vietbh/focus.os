<?php

declare(strict_types=1);

namespace App\Dashboard\Application\DTO\Heatmap;

/**
 * @phpstan-type Weeks list<HeatmapWeek>
 */
final readonly class Heatmap
{
    /**
     * @param list<HeatmapWeek> $weeks
     */
    public function __construct(
        public array $weeks,
    ) {}

    public static function empty(): self
    {
        return new self([]);
    }
}
