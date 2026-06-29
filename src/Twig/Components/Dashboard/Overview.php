<?php

namespace App\Twig\Components\Dashboard;

use App\Dashboard\Application\DTO\OverviewSnapshot;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Overview
{
    public OverviewSnapshot $overview;
}
