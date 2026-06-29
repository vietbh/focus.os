<?php

namespace App\Twig\Components\Dashboard;

use App\Dashboard\Application\DTO\ReviewSnapshot;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ReviewStatus
{
    use DefaultActionTrait;

    public ReviewSnapshot $review;
}
