<?php

declare(strict_types=1);

namespace App\Dashboard\Application\Query;

use App\Dashboard\Application\DTO\DashboardSnapshot;
use App\Dashboard\Application\DTO\OverviewSnapshot;
use App\Dashboard\Application\DTO\ReviewSnapshot;
use App\Dashboard\Application\DTO\TodaySnapshot;
use App\Goal\Domain\Enum\GoalStatus;
use App\Goal\Domain\Repository\GoalRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;
use App\Inbox\Domain\Repository\InboxItemRepositoryInterface;
use App\Review\Domain\Repository\DailyReviewRepositoryInterface;
use App\SharedKernel\Domain\Service\ClockInterface;
use App\Task\Application\UseCase\GetCurrentTaskUseCase;
use App\Task\Domain\Repository\TaskRepositoryInterface;
use App\Task\Domain\Repository\TaskStatusHistoryRepositoryInterface;
use App\Task\Domain\Enum\TaskStatus;
use App\Area\Domain\Repository\AreaRepositoryInterface;

final readonly class DashboardQueryService
{
    public function __construct(
        private InboxItemRepositoryInterface $inboxItems,
        private GoalRepositoryInterface $goals,
        private AreaRepositoryInterface $areas,
        private TaskRepositoryInterface $tasks,
        private TaskStatusHistoryRepositoryInterface $taskStatusHistories,
        private DailyReviewRepositoryInterface $dailyReviews,
        private GetCurrentTaskUseCase $getCurrentTaskUseCase,
        private ClockInterface $clock,
    ) {
    }

    public function getSnapshot(
        UserId $userId,
    ): DashboardSnapshot {
        return new DashboardSnapshot(
            overview: new OverviewSnapshot(
                inboxCount: $this->inboxItems->countNewItems(
                    $userId,
                ),
                goalCount: count(
                    $this->goals->findByUserIdAndStatus(
                        $userId,
                        GoalStatus::ACTIVE,
                    ),
                ),
                areaCount: count(
                    $this->areas->findByUserId(
                        $userId,
                    ),
                ),
                taskCount: $this->tasks->countActiveTasks(
                    $userId,
                ),
            ),
            today: new TodaySnapshot(
                doneTasks: $this->taskStatusHistories
                    ->countStatusChangedBetween(
                        $userId,
                        TaskStatus::DONE,
                        $this->clock->now()->modify('-1 day'),
                        $this->clock->now()->modify('+1 day'),
                    ),
                interruptedTasks: $this->taskStatusHistories
                    ->countStatusChangedBetween(
                        $userId,
                        TaskStatus::INTERRUPTED,
                        $this->clock->now()->modify('-1 day'),
                        $this->clock->now()->modify('+1 day'),
                    ),
            ),
            review: new ReviewSnapshot(
                reviewCompletedToday:
                $this->dailyReviews
                    ->hasReviewForDate(
                        $userId,
                        $this->clock->now(),
                    ),
            ),
            currentTask: $this->getCurrentTaskUseCase
                ->execute(
                    $userId->value(),
                ),
            activeGoals: $this->goals
                ->findByUserIdAndStatus(
                    $userId,
                    GoalStatus::ACTIVE,
                ),
        );
    }
}
