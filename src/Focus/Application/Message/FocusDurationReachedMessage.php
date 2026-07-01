<?php

namespace App\Focus\Application\Message;

use App\Focus\Domain\ValueObject\FocusSessionId;

final readonly class FocusDurationReachedMessage
{
    public function __construct(
        public FocusSessionId $sessionId,
    ) {
    }
}
