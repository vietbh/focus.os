<?php

namespace App\Twig\Components\Dashboard;

use App\Dashboard\Application\DTO\TodaySnapshot;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class TodaySummary
{
    use DefaultActionTrait;

    #[LiveProp]
    public TodaySnapshot $today;
}
