<?php

declare(strict_types=1);

namespace App\Focus\Application\Analytics\DTO;

enum HeatmapLevel: int
{
    case NONE = 0;
    case LOW = 1;
    case MEDIUM = 2;
    case HIGH = 3;
    case EXTREME = 4;
}
