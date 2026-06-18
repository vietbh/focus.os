<?php

declare(strict_types=1);

namespace App\Goal\Domain\Enum;

enum GoalStatus: string
{
    case ACTIVE = 'ACTIVE';

    case COMPLETED = 'COMPLETED';

    case CANCELLED = 'CANCELLED';

    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }

    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }

    public function isCancelled(): bool
    {
        return $this === self::CANCELLED;
    }
}
