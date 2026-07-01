<?php

declare(strict_types=1);

namespace App\Focus\Application\UseCase;

use App\Focus\Application\Command\StopFocusSessionCommand;

final readonly class StopFocusSessionUseCase extends AbstractFocusSessionUseCase
{
    public function execute(
        StopFocusSessionCommand $command,
    ): void {
        $session = $this->getSession(
            $command->sessionId,
        );

        $session->stop();

        $this->save($session);
    }
}
