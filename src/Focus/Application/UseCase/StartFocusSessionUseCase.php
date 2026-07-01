<?php

declare(strict_types=1);

namespace App\Focus\Application\UseCase;

use App\Focus\Application\Command\StartFocusSessionCommand;
use App\Focus\Domain\Entity\FocusSession;
use App\Focus\Domain\Exception\FocusSessionException;

final readonly class StartFocusSessionUseCase extends AbstractFocusSessionUseCase
{
    public function execute(
        StartFocusSessionCommand $command,
    ): FocusSession {
        if (
            $this->focusSessionRepository
                ->activeSessionOfUser($command->userId) !== null
        ) {
            throw FocusSessionException::activeSessionAlreadyExists();
        }

        $session = FocusSession::start(
            $command->userId,
            $command->taskId,
        );

        $this->focusSessionRepository->save($session);

        return $session;
    }
}
