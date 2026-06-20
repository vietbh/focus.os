<?php

declare(strict_types=1);

namespace App\Review\Application\UseCase;

use App\Dashboard\Application\Query\DashboardQueryService;
use App\Identity\Domain\ValueObject\UserId;
use App\Review\Application\DTO\DailyReviewSummaryView;

final readonly class GetDailyReviewSummaryUseCase
{
    public function __construct(
        private DashboardQueryService $dashboardQueryService,
    ) {
    }

    public function execute(
        UserId $userId,
    ): DailyReviewSummaryView {
        $snapshot = $this->dashboardQueryService
            ->getSnapshot(
                $userId,
            );

        return new DailyReviewSummaryView(
            completedTasks: $snapshot->today->doneTasks,
            interruptedTasks: $snapshot->today->interruptedTasks,
            focusMinutes: $snapshot->today->focusMinutes,
        );
    }
}
