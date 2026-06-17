<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class ConfirmDialog
{
    public string $message = 'Are you sure?';
}
