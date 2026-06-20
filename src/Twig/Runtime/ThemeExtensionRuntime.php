<?php

namespace App\Twig\Runtime;

use App\Identity\Application\Service\ThemeResolver;
use Twig\Extension\RuntimeExtensionInterface;

readonly class ThemeExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private ThemeResolver $resolver,
    )
    {
        // Inject dependencies if needed
    }

    public function currentTheme(): string
    {
        return $this->resolver
            ->resolve()
            ->value;
    }
}
