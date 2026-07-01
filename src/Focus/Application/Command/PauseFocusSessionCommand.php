<?php

declare(strict_types=1);

namespace App\Focus\Application\Command;

use App\Focus\Domain\ValueObject\FocusSessionId;

final readonly class PauseFocusSessionCommand
{
    public function __construct(
        public FocusSessionId $sessionId,
        public ?\DateTimeImmutable $pausedAt = null,
    ) {
    }
}
