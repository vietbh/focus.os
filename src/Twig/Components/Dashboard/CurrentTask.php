<?php

namespace App\Twig\Components\Dashboard;

use App\Task\Domain\Entity\Task;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class CurrentTask
{
    use DefaultActionTrait;

    public ?Task $currentTask;
}
