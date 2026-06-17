<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Button
{
    public string $variant = 'primary';

    public string $type = 'button';

    public bool $fullWidth = false;

    public function classes(): string
    {
        $base = '
            inline-flex
            items-center
            justify-center

            rounded-xl

            px-4
            py-2.5

            text-sm
            font-medium

            transition
        ';

        $variant = match ($this->variant) {
            'secondary' => '
                border
                border-slate-200
                bg-white
                text-slate-700
                hover:bg-slate-50
            ',
            'danger' => '
                bg-rose-600
                text-white
                hover:bg-rose-700
            ',
            default => '
                bg-slate-900
                text-white
                hover:bg-slate-800
            ',
        };

        $width = $this->fullWidth
            ? 'w-full'
            : '';

        return trim(
            sprintf(
                '%s %s %s',
                $base,
                $variant,
                $width,
            ),
        );
    }
}
