<?php

declare(strict_types=1);

namespace App\Task\Domain\ValueObject;

use App\Task\Domain\Exception\EmptyTaskTitle;

final readonly class TaskTitle
{
    public function __construct(
        private string $value
    ) {
        if (trim($value) === '') {
            throw new EmptyTaskTitle();
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
