<?php

declare(strict_types=1);

namespace App\Task\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\Entity\Task;
use App\Task\Domain\Repository\TaskRepositoryInterface;

final readonly class GetCurrentTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $tasks,
    ) {
    }

    public function execute(
        string $userId,
    ): ?Task {
        return $this->tasks->findDoingTask(
            UserId::fromString($userId),
        );
    }
}
