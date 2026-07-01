<?php

declare(strict_types=1);

namespace App\Focus\Application\UseCase;

use App\Focus\Application\Command\PauseFocusSessionCommand;

final readonly class PauseFocusSessionUseCase extends AbstractFocusSessionUseCase
{
    public function execute(
        PauseFocusSessionCommand $command,
    ): void {
        $session = $this->getSession(
            $command->sessionId,
        );

        $session->pause();

        $this->save($session);
    }
}
