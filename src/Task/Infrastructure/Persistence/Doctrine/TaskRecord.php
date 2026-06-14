<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence\Doctrine;

final class TaskRecord
{
    public string $id;

    public string $title;

    public string $nextAction;

    public string $status;

    public \DateTimeImmutable $createdAt;

    public \DateTimeImmutable $updatedAt;
}
