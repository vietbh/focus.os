<?php

declare(strict_types=1);

namespace App\Goal\Application\UseCase;

use App\Goal\Domain\Exception\GoalNotFoundException;
use App\Goal\Domain\Repository\GoalRepositoryInterface;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;
use App\SharedKernel\Domain\Service\ClockInterface;

final readonly class CompleteGoalUseCase
{
    public function __construct(
        private GoalRepositoryInterface $goals,
        private ClockInterface $clock,
    ) {
    }

    public function execute(
        UserId $userId,
        GoalId $goalId,
    ): void {
        $goal = $this->goals->findById(
            $goalId,
        );

        if (
            $goal === null
            || !$goal->ownedBy(
                $userId,
            )
        ) {
            throw new GoalNotFoundException();
        }

        $goal->complete(
            $this->clock->now(),
        );

        $this->goals->save(
            $goal,
        );
    }
}
