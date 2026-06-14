<?php

declare(strict_types=1);

namespace App\Goal\Application\UseCase;

use App\Goal\Domain\Repository\GoalRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;

final readonly class GetGoalListUseCase
{
    public function __construct(
        private GoalRepositoryInterface $goals,
    ) {
    }

    public function execute(
        UserId $userId,
    ): array {
        return $this->goals->findByUserId(
            $userId,
        );
    }
}
