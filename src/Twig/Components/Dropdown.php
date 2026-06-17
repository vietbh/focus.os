<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Dropdown
{
    public string $label = 'Menu';

    public string $align = 'right';
}
