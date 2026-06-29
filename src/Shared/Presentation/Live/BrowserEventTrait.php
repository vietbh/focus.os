<?php

namespace App\Shared\Presentation\Live;

use Symfony\UX\LiveComponent\ComponentToolsTrait;

trait BrowserEventTrait
{
    use ComponentToolsTrait;

    protected function dispatchAppEvent(
        string $name,
        array $payload = [],
    ): void {
        $this->dispatchBrowserEvent(
            sprintf('app:%s', $name),
            $payload,
        );
    }
}
