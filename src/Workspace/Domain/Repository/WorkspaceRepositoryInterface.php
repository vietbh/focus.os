<?php

declare(strict_types=1);

namespace App\Workspace\Domain\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Workspace\Domain\Entity\Workspace;
use App\Workspace\Domain\ValueObject\WorkspaceId;

interface WorkspaceRepositoryInterface
{
    public function save(
        Workspace $workspace,
    ): void;

    public function remove(
        Workspace $workspace,
    ): void;

    public function get(
        WorkspaceId $id,
    ): ?Workspace;

    /**
     * @return Workspace[]
     */
    public function findByOwner(
        UserId $ownerId,
    ): array;

    public function existsByOwnerAndName(
        UserId $ownerId,
        string $name,
    ): bool;
}
