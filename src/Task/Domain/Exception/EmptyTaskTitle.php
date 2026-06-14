<?php

declare(strict_types=1);

namespace App\Task\Domain\Exception;

final class EmptyTaskTitle extends TaskException
{
    public function __construct()
    {
        parent::__construct(
            'Task title cannot be empty.'
        );
    }
}
