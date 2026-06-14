<?php

declare(strict_types=1);

namespace App\Goal\Application\UseCase;

use App\Goal\Application\DTO\CreateGoalInput;
use App\Goal\Domain\Entity\Goal;
use App\Goal\Domain\Repository\GoalRepositoryInterface;
use App\Goal\Domain\ValueObject\GoalId;
use App\SharedKernel\Domain\Service\ClockInterface;
use Symfony\Component\Uid\Uuid;

final readonly class CreateGoalUseCase
{
    public function __construct(
        private GoalRepositoryInterface $goals,
        private ClockInterface $clock,
    ) {
    }

    public function execute(
        CreateGoalInput $input,
    ): Goal {
        $goal = Goal::create(
            id: GoalId::fromString(
                Uuid::v7()->toRfc4122(),
            ),
            userId: $input->userId,
            title: $input->title,
            description: $input->description,
            targetDate: $input->targetDate,
            createdAt: $this->clock->now(),
        );

        $this->goals->save(
            $goal,
        );

        return $goal;
    }
}
