<?php

declare(strict_types=1);

namespace App\Identity\Domain\Enum;

enum Theme: string
{
    case SYSTEM = 'system';

    case LIGHT = 'light';

    case DARK = 'dark';

    public function label(): string
    {
        return match ($this) {
            self::SYSTEM => 'System',
            self::LIGHT => 'Light',
            self::DARK => 'Dark',
        };
    }
}
