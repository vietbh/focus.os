<?php

declare(strict_types=1);

namespace App\Goal\Application\UseCase;

use App\Goal\Application\DTO\UpdateGoalInput;
use App\Goal\Domain\Repository\GoalRepositoryInterface;
use App\Goal\Domain\Exception\GoalNotFoundException;
use App\Identity\Domain\ValueObject\UserId;
use App\SharedKernel\Domain\Service\ClockInterface;

final readonly class UpdateGoalUseCase
{
    public function __construct(
        private GoalRepositoryInterface $goals,
        private ClockInterface $clock,
    ) {
    }

    public function execute(
        UserId $userId,
        UpdateGoalInput $input,
    ): void {
        $goal = $this->goals->findById(
            $input->goalId,
        );

        if (
            $goal === null
            || !$goal->ownedBy(
                $userId,
            )
        ) {
            throw new GoalNotFoundException();
        }

        $goal->update(
            title: $input->title,
            description: $input->description,
            targetDate: $input->targetDate,
            updatedAt: $this->clock->now(),
        );

        $this->goals->save(
            $goal,
        );
    }
}
