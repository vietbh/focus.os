<?php

namespace App\Workspace\Application\Command;

use App\Workspace\Domain\ValueObject\WorkspaceId;

final readonly class UpdateWorkspaceCommand
{
    public function __construct(
        public WorkspaceId $workspaceId,
        public string $name,
        public ?string $description,
        public ?string $icon,
        public ?string $color,
    ) {
    }
}
