<?php

declare(strict_types=1);

namespace App\Task\Domain\Service;

use App\Task\Domain\ValueObject\TaskId;

interface SingleDoingRule
{
    public function ensure(TaskId $taskId): void;
}
