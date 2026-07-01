<?php

declare(strict_types=1);

namespace App\Focus\Domain\ValueObject;

use App\Focus\Domain\Enum\FocusEventType;

final readonly class FocusEvent
{
    public function __construct(
        private FocusEventType $type,
        private \DateTimeImmutable $occurredAt,
    ) {
    }

    public static function start(
        \DateTimeImmutable $occurredAt,
    ): self {
        return new self(
            FocusEventType::STARTED,
            $occurredAt,
        );
    }

    public static function pause(
        \DateTimeImmutable $occurredAt,
    ): self {
        return new self(
            FocusEventType::PAUSED,
            $occurredAt,
        );
    }

    public static function resume(
        \DateTimeImmutable $occurredAt,
    ): self {
        return new self(
            FocusEventType::RESUMED,
            $occurredAt,
        );
    }

    public static function stop(
        \DateTimeImmutable $occurredAt,
    ): self {
        return new self(
            FocusEventType::STOPED,
            $occurredAt,
        );
    }

    public function type(): FocusEventType
    {
        return $this->type;
    }

    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
