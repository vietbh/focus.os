<?php

declare(strict_types=1);

namespace App\Task\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\Repository\TaskRepositoryInterface;

final readonly class GetTaskListUseCase
{
    public function __construct(
        private TaskRepositoryInterface $tasks,
    ) {
    }

    public function execute(
        string $userId,
    ): array {
        return $this->tasks->findByUserId(
            UserId::fromString($userId),
        );
    }
}
