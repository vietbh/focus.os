<?php

namespace App\Twig\Components\Dashboard;

use App\Goal\Domain\Entity\Goal;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class GoalList
{
    use DefaultActionTrait;

    /** @var list<Goal> */
    public array $goals;
}
