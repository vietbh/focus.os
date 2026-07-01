<?php

declare(strict_types=1);

namespace App\Focus\Application\UseCase;

use App\Focus\Application\Command\ResumeFocusSessionCommand;

final readonly class ResumeFocusSessionUseCase extends AbstractFocusSessionUseCase
{
    public function execute(
        ResumeFocusSessionCommand $command,
    ): void {
        $session = $this->getSession(
            $command->sessionId,
        );

        $session->resume();

        $this->save($session);
    }
}
