<?php

namespace App\Twig\Components;

use App\Shared\Presentation\Navigation\NavigationProvider;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final readonly class MobileNavigation
{
    public function __construct(
        private NavigationProvider $provider,
        private RequestStack $requestStack,
    ) {}

    public function primaryItems(): array
    {
        return $this->provider->primaryItems();
    }

    public function reviewItems(): array
    {
        return $this->provider->reviewItems();
    }

    public function isActive(
        string $routePrefix,
    ): bool {
        $route = (string) $this
            ->requestStack
            ->getCurrentRequest()
            ?->attributes
            ->get('_route', '');

        return str_starts_with(
            $route,
            $routePrefix,
        );
    }
}
