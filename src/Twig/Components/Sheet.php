<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Sheet
{
    public string $id;

    public string $title = '';

    public string $size = 'md';

    public string $position = 'bottom';

    public bool $closeOnBackdrop = true;

    public bool $closeOnEscape = true;
}
