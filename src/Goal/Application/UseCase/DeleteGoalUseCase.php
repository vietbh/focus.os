<?php

declare(strict_types=1);

namespace App\Goal\Application\UseCase;

use App\Area\Domain\Repository\AreaRepositoryInterface;
use App\Goal\Domain\Exception\GoalNotFoundException;
use App\Goal\Domain\Repository\GoalRepositoryInterface;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;

final readonly class DeleteGoalUseCase
{
    public function __construct(
        private GoalRepositoryInterface $goals,
        private AreaRepositoryInterface $areaRepository,
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

        $areas = $this->areaRepository->findByGoalId(
            $goal->id(),
        );

        foreach ($areas as $area) {
            $area->removeGoal();

            $this->areaRepository->save(
                $area,
            );
        }

        $this->goals->remove(
            $goal,
        );
    }
}
