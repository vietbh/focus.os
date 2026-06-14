<?php

declare(strict_types=1);

namespace App\Task\Domain\Exception;

use App\SharedKernel\Domain\Exception\NotFoundException;

final class TaskNotFoundException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct(
            'Task not found.',
        );
    }
}
