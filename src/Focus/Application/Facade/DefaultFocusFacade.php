<?php

declare(strict_types=1);

namespace App\Focus\Application\Facade;

use App\Focus\Application\Command\PauseFocusSessionCommand;
use App\Focus\Application\Command\ResumeFocusSessionCommand;
use App\Focus\Application\Command\StartFocusSessionCommand;
use App\Focus\Application\Command\StopFocusSessionCommand;
use App\Focus\Application\DTO\FocusSessionDto;
use App\Focus\Application\Query\CurrentFocusSessionQuery;
use App\Focus\Application\QueryHandler\CurrentFocusSessionHandler;
use App\Focus\Domain\ValueObject\FocusSessionId;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class DefaultFocusFacade implements FocusFacade
{
    public function __construct(
        private CurrentFocusSessionHandler $currentHandler,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function current(
        UserId $userId,
    ): ?FocusSessionDto {
        return $this->currentHandler->execute(
            new CurrentFocusSessionQuery($userId),
        );
    }

    /**
     * @throws ExceptionInterface
     */
    public function start(
        UserId $userId,
        TaskId $taskId,
    ): void {
        $this->messageBus->dispatch(
            new StartFocusSessionCommand(
                $userId,
                $taskId,
            ),
        );
    }

    /**
     * @throws ExceptionInterface
     */
    public function pause(
        FocusSessionId $sessionId,
    ): void {
        $this->messageBus->dispatch(
            new PauseFocusSessionCommand(
                $sessionId,
            ),
        );
    }

    /**
     * @throws ExceptionInterface
     */
    public function resume(
        FocusSessionId $sessionId,
    ): void {
        $this->messageBus->dispatch(
            new ResumeFocusSessionCommand(
                $sessionId,
            ),
        );
    }

    /**
     * @throws ExceptionInterface
     */
    public function stop(
        FocusSessionId $sessionId,
    ): void {
        $this->messageBus->dispatch(
            new StopFocusSessionCommand(
                $sessionId,
            ),
        );
    }
}
