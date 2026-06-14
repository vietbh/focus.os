<?php

declare(strict_types=1);

namespace App\Task\Domain\Enum;

enum TaskStatus: string
{
    case TODO = 'TODO';

    case DOING = 'DOING';

    case INTERRUPTED = 'INTERRUPTED';

    case DONE = 'DONE';
}
