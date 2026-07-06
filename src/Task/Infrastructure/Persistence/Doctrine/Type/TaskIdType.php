<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence\Doctrine\Type;

use App\Shared\Infrastructure\Doctrine\Type\AbstractIdentityType;
use App\Task\Domain\ValueObject\TaskId;

final class TaskIdType extends AbstractIdentityType
{
    public const NAME = 'task_id';

    protected function valueObjectClass(): string
    {
        return TaskId::class;
    }
}
