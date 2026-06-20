<?php

namespace App\Twig\Components;

use App\Shared\Presentation\Navigation\NavigationProvider;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent]
final readonly class BottomNavigation
{
    public function __construct(
        private NavigationProvider $provider,
        private RequestStack       $requestStack,
    ) {
    }

    #[ExposeInTemplate]
    public function items(): array
    {
        return $this->provider->mobileItems();
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
