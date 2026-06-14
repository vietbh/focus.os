<?php

declare(strict_types=1);

namespace App\Area\Domain\Exception;

use App\SharedKernel\Domain\Exception\NotFoundException;

final class AreaNotFoundException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct(
            'Area not found.',
        );
    }
}
