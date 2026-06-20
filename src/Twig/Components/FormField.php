<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class FormField
{
    public string $label = '';

    public ?string $help = null;

    public ?string $error = null;
}
