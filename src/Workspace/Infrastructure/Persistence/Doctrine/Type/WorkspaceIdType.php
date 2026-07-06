<?php

declare(strict_types=1);

namespace App\Workspace\Infrastructure\Persistence\Doctrine\Type;

use App\Shared\Infrastructure\Doctrine\Type\AbstractIdentityType;
use App\Workspace\Domain\ValueObject\WorkspaceId;

final class WorkspaceIdType extends AbstractIdentityType
{
    public const NAME = 'workspace_id';

    protected function valueObjectClass(): string
    {
        return WorkspaceId::class;
    }
}
