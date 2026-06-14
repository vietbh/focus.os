<?php

declare(strict_types=1);

namespace App\Task\Domain\Exception;

final class EmptyNextAction extends TaskException
{
    public function __construct()
    {
        parent::__construct(
            'Next action cannot be empty.'
        );
    }
}
