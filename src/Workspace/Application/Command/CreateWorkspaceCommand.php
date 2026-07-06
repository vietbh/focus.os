<?php

declare(strict_types=1);

namespace App\Workspace\Application\Command;

final readonly class CreateWorkspaceCommand
{
    public function __construct(
        public string $name,
        public ?string $description = null,
        public ?string $icon = null,
        public ?string $color = null,
    ) {
    }
}
