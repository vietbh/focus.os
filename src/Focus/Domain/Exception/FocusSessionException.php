<?php

declare(strict_types=1);

namespace App\Focus\Domain\Exception;

use App\Focus\Domain\Enum\FocusSessionStatus;
use DomainException;

final class FocusSessionException extends DomainException
{
    public static function alreadyCompleted(): self
    {
        return new self('Focus session has already been completed.');
    }

    public static function alreadyPaused(): self
    {
        return new self('Focus session is already paused.');
    }

    public static function alreadyActive(): self
    {
        return new self('Focus session is already active.');
    }

    public static function cannotPause(
        FocusSessionStatus $currentStatus,
    ): self {
        return new self(sprintf(
            'Cannot pause focus session while status is "%s".',
            $currentStatus->value,
        ));
    }

    public static function cannotResume(
        FocusSessionStatus $currentStatus,
    ): self {
        return new self(sprintf(
            'Cannot resume focus session while status is "%s".',
            $currentStatus->value,
        ));
    }

    public static function cannotStop(
        FocusSessionStatus $currentStatus,
    ): self {
        return new self(sprintf(
            'Cannot stop focus session while status is "%s".',
            $currentStatus->value,
        ));
    }

    public static function missingPauseTimestamp(): self
    {
        return new self(
            'Pause timestamp is missing.',
        );
    }

    public static function invalidTimeRange(): self
    {
        return new self(
            'The provided timestamps are invalid.',
        );
    }

    public static function notFound(): self
    {
        return new self(
            'Focus session not found.',
        );
    }

    public static function activeSessionAlreadyExists(): self
    {
        return new self(
            'The user already has an active focus session.',
        );
    }

}
