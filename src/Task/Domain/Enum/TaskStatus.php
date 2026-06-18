<?php

declare(strict_types=1);

namespace App\Task\Domain\Enum;

enum TaskStatus: string
{
    case TODO = 'TODO';
    case DOING = 'DOING';
    case INTERRUPTED = 'INTERRUPTED';
    case DONE = 'DONE';

    public function label(): string
    {
        return match ($this) {
            self::TODO => 'Todo',
            self::DOING => 'Doing',
            self::INTERRUPTED => 'Interrupted',
            self::DONE => 'Done',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::TODO => '
            bg-slate-100
            text-slate-700
        ',

            self::DOING => '
            bg-emerald-100
            text-emerald-700
        ',

            self::INTERRUPTED => '
            bg-amber-100
            text-amber-700
        ',

            self::DONE => '
            bg-slate-900
            text-white
        ',
        };
    }

    public function isTodo(): bool
    {
        return self::TODO === $this;
    }

    public function isDoing(): bool
    {
        return self::DOING === $this;
    }

    public function isInterrupted(): bool
    {
        return self::INTERRUPTED === $this;
    }

    public function isDone(): bool
    {
        return self::DONE === $this;
    }
}
