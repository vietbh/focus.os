<?php

declare(strict_types=1);

namespace App\Workspace\Application\DTO;

final readonly class WorkspaceSummaryDto
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
        public ?string $icon,
        public ?string $color,
        public bool $current = false,
    ) {
    }
}
