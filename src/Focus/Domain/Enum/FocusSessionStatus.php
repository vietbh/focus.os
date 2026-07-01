<?php

declare(strict_types=1);

namespace App\Focus\Domain\Enum;

enum FocusSessionStatus: string
{
    case ACTIVE = 'active';

    case PAUSED = 'paused';

    case COMPLETED = 'completed';

    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }

    public function isPaused(): bool
    {
        return $this === self::PAUSED;
    }

    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }
}
