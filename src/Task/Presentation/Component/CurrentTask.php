<?php

namespace App\Task\Presentation\Component;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent(template: 'Task/Presentation/Component/CurrentTask.html.twig')]
final class CurrentTask
{
    use DefaultActionTrait;
}
