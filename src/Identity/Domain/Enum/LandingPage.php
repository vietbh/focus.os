<?php

declare(strict_types=1);

namespace App\Identity\Domain\Enum;

enum LandingPage: string
{
    case TODAY = 'today';

    case TASKS = 'tasks';

    case NOTES = 'notes';

    case GOALS = 'goals';

    public function label(): string
    {
        return match ($this) {
            self::TODAY => 'Today',
            self::TASKS => 'Tasks',
            self::NOTES => 'Notes',
            self::GOALS => 'Goals',
        };
    }
}
