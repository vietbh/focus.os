<?php

declare(strict_types=1);

namespace App\Focus\Domain\Service;

use App\Focus\Domain\Entity\FocusSession;

final readonly class DefaultFocusDurationCalculator implements FocusDurationCalculator
{
    public function calculate(
        FocusSession $session,
    ): int {
        $end = match (true) {
            $session->isCompleted() => $session->endedAt(),
            $session->isPaused() => $session->pausedAt(),
            default => new \DateTimeImmutable(),
        };

        if ($end === null) {
            return 0;
        }

        return max(
            0,
            $end->getTimestamp()
            - $session->startedAt()->getTimestamp()
            - $session->pausedSeconds(),
        );
    }
}
