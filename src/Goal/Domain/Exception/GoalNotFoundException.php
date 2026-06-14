<?php

declare(strict_types=1);

namespace App\Goal\Domain\Exception;

use App\SharedKernel\Domain\Exception\NotFoundException;

final class GoalNotFoundException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct(
            'Goal not found.',
        );
    }
}
