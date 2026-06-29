<?php

namespace App\Twig\Components\Notification;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Toast
{
    public string $type = 'success';

    public string $title = '';

    public string $message = '';

    public int $duration = 4000;

    public bool $dismissible = true;
}
