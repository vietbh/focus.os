<?php

declare(strict_types=1);

namespace App\Focus\Domain\Enum;

enum FocusEventType: string
{
    case STARTED = 'started';

    case PAUSED = 'paused';

    case RESUMED = 'resumed';

    case STOPED = 'stoped';

    public function isStarted(): bool
    {
        return $this === self::STARTED;
    }

    public function isPaused(): bool
    {
        return $this === self::PAUSED;
    }

    public function isResumed(): bool
    {
        return $this === self::RESUMED;
    }

    public function isStoped(): bool
    {
        return $this === self::STOPED;
    }
}
