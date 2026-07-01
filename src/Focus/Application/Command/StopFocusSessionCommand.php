<?php

declare(strict_types=1);

namespace App\Focus\Application\Command;

use App\Focus\Domain\ValueObject\FocusSessionId;

final readonly class StopFocusSessionCommand
{
    public function __construct(
        public FocusSessionId $sessionId,
        public ?\DateTimeImmutable $endedAt = null,
    ) {
    }
}
