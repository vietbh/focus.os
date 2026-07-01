<?php

declare(strict_types=1);

namespace App\Focus\Application\Facade;

use App\Focus\Application\DTO\FocusSessionDto;
use App\Focus\Domain\ValueObject\FocusSessionId;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\ValueObject\TaskId;

interface FocusFacade
{
    public function current(
        UserId $userId,
    ): ?FocusSessionDto;

    public function start(
        UserId $userId,
        TaskId $taskId,
    ): void;

    public function pause(
        FocusSessionId $sessionId,
    ): void;

    public function resume(
        FocusSessionId $sessionId,
    ): void;

    public function stop(
        FocusSessionId $sessionId,
    ): void;
}
