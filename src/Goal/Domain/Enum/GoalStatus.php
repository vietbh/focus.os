<?php

declare(strict_types=1);

namespace App\Goal\Domain\Enum;

enum GoalStatus: string
{
    case ACTIVE = 'ACTIVE';

    case COMPLETED = 'COMPLETED';

    case CANCELLED = 'CANCELLED';
}
