<?php

declare(strict_types=1);

namespace App\Dashboard\Application\DTO\Heatmap;

enum HeatmapLevel: int
{
    case NONE = 0;
    case LOW = 1;
    case MEDIUM = 2;
    case HIGH = 3;
    case EXTREME = 4;
}
