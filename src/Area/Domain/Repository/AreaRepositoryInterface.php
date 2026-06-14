<?php

declare(strict_types=1);

namespace App\Area\Domain\Repository;

use App\Area\Domain\Entity\Area;
use App\Area\Domain\ValueObject\AreaId;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;

interface AreaRepositoryInterface
{
    public function save(
        Area $area,
    ): void;

    public function remove(
        Area $area,
    ): void;

    public function findById(
        AreaId $id,
    ): ?Area;

    /**
     * @return Area[]
     */
    public function findByUserId(
        UserId $userId,
    ): array;

    public function countByUserId(
        UserId $userId,
    ): int;

    /**
     * @return Area[]
     */
    public function findByGoalId(
        GoalId $goalId,
    ): array;
}
