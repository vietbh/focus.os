<?php

declare(strict_types=1);

namespace App\Workspace\Application\Command;

use App\Workspace\Domain\ValueObject\WorkspaceId;

final readonly class SwitchWorkspaceCommand
{
    public function __construct(
        public WorkspaceId $workspaceId,
    ) {
    }
}
