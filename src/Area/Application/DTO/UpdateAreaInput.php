<?php

declare(strict_types=1);

namespace App\Area\Application\DTO;

use App\Area\Domain\ValueObject\AreaId;
use App\Goal\Domain\ValueObject\GoalId;

final readonly class UpdateAreaInput
{
    public function __construct(
        public AreaId $areaId,
        public ?GoalId $goalId,
        public string $name,
    ) {
    }
}
