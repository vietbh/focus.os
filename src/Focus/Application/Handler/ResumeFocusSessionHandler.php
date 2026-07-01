<?php

namespace App\Focus\Application\Handler;

use App\Focus\Application\Command\ResumeFocusSessionCommand;
use App\Focus\Application\UseCase\ResumeFocusSessionUseCase;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AsMessageHandler]
class ResumeFocusSessionHandler
{
    public function __construct(
        private readonly ResumeFocusSessionUseCase $useCase,
    ) {
    }

    public function __invoke(
        ResumeFocusSessionCommand $command,
    ): void
    {
        $this->useCase->execute($command);
    }
}
