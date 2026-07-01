<?php

declare(strict_types=1);

namespace App\Focus\Application\QueryHandler;

use App\Focus\Application\DTO\FocusSessionDto;
use App\Focus\Application\Query\CurrentFocusSessionQuery;
use App\Focus\Application\QueryRepository\FocusAnalyticsQueryInterface;

final readonly class CurrentFocusSessionHandler
{
    public function __construct(
        private FocusAnalyticsQueryInterface $queryRepository,
    ) {
    }

    public function execute(
        CurrentFocusSessionQuery $query,
    ): ?FocusSessionDto {
        return $this->queryRepository->currentOfUser(
            $query->userId,
        );
    }
}
