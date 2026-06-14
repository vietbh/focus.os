<?php

declare(strict_types=1);

namespace App\Dashboard\Application\DTO;

final readonly class ReviewSnapshot
{
    public function __construct(
        public bool $reviewCompletedToday,
    ) {
    }
}
