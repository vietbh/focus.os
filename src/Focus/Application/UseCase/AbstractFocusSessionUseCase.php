<?php

declare(strict_types=1);

namespace App\Focus\Application\UseCase;

use App\Focus\Domain\Entity\FocusSession;
use App\Focus\Domain\Exception\FocusSessionException;
use App\Focus\Domain\Repository\FocusSessionRepositoryInterface;
use App\Focus\Domain\ValueObject\FocusSessionId;

abstract readonly class AbstractFocusSessionUseCase
{
    public function __construct(
        protected FocusSessionRepositoryInterface $focusSessionRepository,
    ) {
    }

    protected function getSession(
        FocusSessionId $sessionId,
    ): FocusSession {
        $session = $this->focusSessionRepository->ofId($sessionId);

        if ($session === null) {
            throw FocusSessionException::notFound();
        }

        return $session;
    }

    protected function save(
        FocusSession $session,
    ): void {
        $this->focusSessionRepository->save($session);
    }
}
