<?php

namespace App\Focus\Application\Handler;

use App\Focus\Application\Command\StartFocusSessionCommand;
use App\Focus\Application\Message\FocusDurationReachedMessage;
use App\Focus\Application\UseCase\StartFocusSessionUseCase;
use App\Focus\Domain\Entity\FocusSession;
use App\Task\Domain\Repository\TaskRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

#[AsMessageHandler]
final readonly class StartFocusSessionHandler
{
    public function __construct(
        private StartFocusSessionUseCase $useCase,
        private MessageBusInterface      $bus, private TaskRepositoryInterface $taskRepository,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(
        StartFocusSessionCommand $command,
    ): FocusSession {

        $session = $this->useCase->execute($command);
        $task = $this->taskRepository->findById($command->taskId);

        $this->bus->dispatch(
            new FocusDurationReachedMessage(
                $session->id(),
            ),
            [
                new DelayStamp(
                    $task->estimatedMinutes() * 60 * 1000,
                ),
            ],
        );
        return $session;

    }
}
