<?php

declare(strict_types=1);

namespace App\Focus\Application\Mapper;

use App\Focus\Application\DTO\FocusSessionDto;
use App\Focus\Domain\Entity\FocusSession;
use App\Focus\Domain\Service\FocusDurationCalculator;

final readonly class FocusSessionMapper
{
    public function __construct(
        private FocusDurationCalculator $calculator,
    ) {
    }

    public function toDto(
        FocusSession $session,
    ): FocusSessionDto {
        return new FocusSessionDto(
            id: $session->id(),
            taskId: $session->taskId(),
            status: $session->status(),
            startedAt: $session->startedAt(),
            pausedAt: $session->pausedAt(),
            endedAt: $session->endedAt(),
            focusSeconds: $this->calculator->calculate($session),
            pausedSeconds: $session->pausedSeconds(),
        );
    }
}
