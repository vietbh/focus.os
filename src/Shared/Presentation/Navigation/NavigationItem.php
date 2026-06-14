<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Navigation;

final readonly class NavigationItem
{
    public function __construct(
        public string $label,
        public string $route,
        public string $routePrefix,
    ) {}
}
