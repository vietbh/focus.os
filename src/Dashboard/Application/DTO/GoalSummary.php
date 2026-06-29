<?php

namespace App\Dashboard\Application\DTO;

final readonly class GoalSummary
{
    public function __construct(
        public string $id,
        public string $title,
        public ?string $description,
        public int $progress,
        public int $activeTaskCount,
    ) {
    }
}
