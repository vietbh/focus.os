<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class NavigationItem
{
    public string $label;

    public string $href;

    public bool $active = false;
}
