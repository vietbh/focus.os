<?php

declare(strict_types=1);

namespace App\Focus\Application\Analytics\Query;


use App\Identity\Domain\ValueObject\UserId;

final readonly class GetHeatmapQuery
{
    public function __construct(
        public UserId $userId,
    ) {
    }
}
