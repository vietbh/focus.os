<?php

namespace App\Focus\Application\Handler;

use App\Focus\Application\Command\PauseFocusSessionCommand;
use App\Focus\Application\UseCase\PauseFocusSessionUseCase;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class PauseFocusSessionHandler
{
    public function __construct(
        private readonly PauseFocusSessionUseCase $useCase,
    ) {
    }

    public function __invoke(
        PauseFocusSessionCommand $command,
    ): void
    {
        $this->useCase->execute($command);
    }
}
