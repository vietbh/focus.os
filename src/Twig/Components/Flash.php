<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Flash
{
    public string $type = 'success';

    public string $message = '';

    public function containerClass(): string
    {
        return match ($this->type) {
            'success' => 'bg-green-50
border-green-200

dark:bg-green-950/40
dark:border-green-900 text-green-800',
            'error' => 'border-red-200 bg-red-50 text-red-800',
            'warning' => 'border-amber-200 bg-amber-50 text-amber-800',
            'info' => 'border-blue-200 bg-blue-50 text-blue-800',
            default => 'border-slate-200 bg-white text-slate-800',
        };
    }
}
