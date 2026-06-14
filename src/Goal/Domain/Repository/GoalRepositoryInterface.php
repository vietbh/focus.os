<?php

declare(strict_types=1);

namespace App\Goal\Domain\Repository;

use App\Goal\Domain\Entity\Goal;
use App\Goal\Domain\Enum\GoalStatus;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;

interface GoalRepositoryInterface
{
    public function save(
        Goal $goal,
    ): void;

    public function remove(
        Goal $goal,
    ): void;

    public function findById(
        GoalId $id,
    ): ?Goal;

    /**
     * @return Goal[]
     */
    public function findByUserId(
        UserId $userId,
    ): array;

    /**
     * @return Goal[]
     */
    public function findByUserIdAndStatus(
        UserId $userId,
        GoalStatus $status,
    ): array;

    public function countActiveGoals(
        UserId $userId,
    ): int;


}
