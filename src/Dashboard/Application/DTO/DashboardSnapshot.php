<?php

declare(strict_types=1);

namespace App\Dashboard\Application\DTO;

use App\Goal\Domain\Entity\Goal;
use App\Task\Domain\Entity\Task;

final readonly class DashboardSnapshot
{

    public function __construct(
        public OverviewSnapshot $overview,
        public TodaySnapshot $today,
        public ReviewSnapshot $review,
        public ?Task $currentTask,
        /**
         * @param list<Goal> $activeGoals
         */
        public array $activeGoals,

        public DashboardStatistics $statistics,
    ) {
    }
}
