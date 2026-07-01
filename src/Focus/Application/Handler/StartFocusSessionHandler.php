<?php

namespace App\Focus\Application\Handler;

use App\Focus\Application\Command\StartFocusSessionCommand;
use App\Focus\Application\UseCase\StartFocusSessionUseCase;
use App\Focus\Domain\Entity\FocusSession;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class StartFocusSessionHandler
{
    public function __construct(
        private StartFocusSessionUseCase $useCase,
    ) {
    }

    public function __invoke(
        StartFocusSessionCommand $command,
    ): FocusSession {
        return $this->useCase->execute($command);
    }
}
