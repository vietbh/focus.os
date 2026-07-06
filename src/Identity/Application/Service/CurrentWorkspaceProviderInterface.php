<?php

declare(strict_types=1);

namespace App\Identity\Application\Service;

use App\Workspace\Domain\Entity\Workspace;

interface CurrentWorkspaceProviderInterface
{
    public function current(): ?Workspace;
}
