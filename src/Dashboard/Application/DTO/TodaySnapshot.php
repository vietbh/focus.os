<?php

declare(strict_types=1);

namespace App\Dashboard\Application\DTO;

final readonly class TodaySnapshot
{
    public function __construct(
        public int $doneTasks,
        public int $interruptedTasks,
    ) {
    }
}
