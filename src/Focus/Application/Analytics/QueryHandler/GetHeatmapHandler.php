<?php

declare(strict_types=1);

namespace App\Focus\Application\Analytics\QueryHandler;

use App\Focus\Application\Analytics\DTO\Heatmap;
use App\Focus\Application\Analytics\Query\GetHeatmapQuery;
use App\Focus\Application\Analytics\QueryRepository\FocusAnalyticsQueryInterface;

final readonly class GetHeatmapHandler
{
    public function __construct(
        private FocusAnalyticsQueryInterface $query,
    ) {
    }

    public function __invoke(
        GetHeatmapQuery $query,
    ): Heatmap {
        return $this->query->heatmap(
            $query->userId,
        );
    }
}
