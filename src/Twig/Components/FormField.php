<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class FormField
{
    public string $label;

    public ?string $hint = null;

    public bool $required = false;
}
