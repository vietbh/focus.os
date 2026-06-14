<?php

declare(strict_types=1);

namespace App\Dashboard\Application\UseCase;

use App\Dashboard\Application\DTO\DashboardSnapshot;
use App\Dashboard\Application\Query\DashboardQueryService;
use App\Identity\Domain\ValueObject\UserId;

final readonly class GetDashboardUseCase
{
    public function __construct(
        private DashboardQueryService $queryService,
    ) {
    }

    public function execute(
        UserId $userId,
    ): DashboardSnapshot {
        return $this->queryService
            ->getSnapshot(
                $userId,
            );
    }
}
