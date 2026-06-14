<?php

declare(strict_types=1);

namespace App\Dashboard\Application\DTO;

final readonly class OverviewSnapshot
{
    public function __construct(
        public int $inboxCount,
        public int $goalCount,
        public int $areaCount,
        public int $taskCount,
    ) {
    }
}
