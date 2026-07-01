<?php

declare(strict_types=1);

namespace App\Focus\Domain\Entity;

use App\Focus\Domain\Enum\FocusEventType;
use App\Focus\Domain\ValueObject\FocusSessionId;

final readonly class FocusEvent
{
    private function __construct(
        private FocusSessionId $sessionId,
        private FocusEventType $type,
        private \DateTimeImmutable $occurredAt,
    ) {
    }

    public static function started(
        FocusSessionId $sessionId,
        \DateTimeImmutable $occurredAt,
    ): self {
        return new self(
            $sessionId,
            FocusEventType::STARTED,
            $occurredAt,
        );
    }

    public static function paused(
        FocusSessionId $sessionId,
        \DateTimeImmutable $occurredAt,
    ): self {
        return new self(
            $sessionId,
            FocusEventType::PAUSED,
            $occurredAt,
        );
    }

    public static function resumed(
        FocusSessionId $sessionId,
        \DateTimeImmutable $occurredAt,
    ): self {
        return new self(
            $sessionId,
            FocusEventType::RESUMED,
            $occurredAt,
        );
    }

    public static function stopped(
        FocusSessionId $sessionId,
        \DateTimeImmutable $occurredAt,
    ): self {
        return new self(
            $sessionId,
            FocusEventType::STOPPED,
            $occurredAt,
        );
    }

    public function sessionId(): FocusSessionId
    {
        return $this->sessionId;
    }

    public function type(): FocusEventType
    {
        return $this->type;
    }

    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }

    public function isStarted(): bool
    {
        return $this->type === FocusEventType::STARTED;
    }

    public function isPaused(): bool
    {
        return $this->type === FocusEventType::PAUSED;
    }

    public function isResumed(): bool
    {
        return $this->type === FocusEventType::RESUMED;
    }

    public function isStopped(): bool
    {
        return $this->type === FocusEventType::STOPPED;
    }
}
