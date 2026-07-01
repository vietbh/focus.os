<?php

declare(strict_types=1);

namespace App\Focus\Application\Analytics\QueryRepository;

use App\Dashboard\Application\DTO\Heatmap\Heatmap;
use App\Identity\Domain\ValueObject\UserId;

interface FocusAnalyticsQueryInterface
{
    public function heatmap(
        UserId $userId,
    ): Heatmap;
}
