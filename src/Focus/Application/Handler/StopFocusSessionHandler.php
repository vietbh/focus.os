<?php

namespace App\Focus\Application\Handler;

use App\Focus\Application\Command\StopFocusSessionCommand;
use App\Focus\Application\UseCase\StopFocusSessionUseCase;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class StopFocusSessionHandler
{
    public function __construct(
        private readonly StopFocusSessionUseCase $useCase,
    ) {
    }

    public function __invoke(
        StopFocusSessionCommand $command,
    ): void
    {
        $this->useCase->execute($command);
    }
}
