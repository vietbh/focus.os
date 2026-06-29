<?php

namespace App\Twig\Components\Dashboard;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class Heatmap
{
    use DefaultActionTrait;

    #[LiveProp]
    public \App\Dashboard\Application\DTO\Heatmap\Heatmap $heatmap;

    public function levelClass(int $level): string
    {
        return match ($level) {
            0 => 'bg-slate-100 dark:bg-slate-700',
            1 => 'bg-emerald-200',
            2 => 'bg-emerald-400',
            3 => 'bg-emerald-600',
            default => 'bg-emerald-800',
        };
    }
}
