<?php

declare(strict_types=1);

namespace App\Goal\Application\UseCase;

use App\Goal\Domain\Entity\Goal;
use App\Goal\Domain\Repository\GoalRepositoryInterface;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;

final readonly class GetGoalDetailUseCase
{
    public function __construct(
        private GoalRepositoryInterface $goals,
    ) {
    }

    public function execute(
        UserId $userId,
        GoalId $goalId,
    ): ?Goal {
        $goal = $this->goals->findById(
            $goalId,
        );

        if ($goal === null) {
            return null;
        }

        if (
            !$goal->ownedBy(
                $userId,
            )
        ) {
            return null;
        }

        return $goal;
    }
}
