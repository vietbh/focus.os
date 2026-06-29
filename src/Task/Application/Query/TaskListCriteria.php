<?php

namespace App\Task\Application\Query;

final readonly class TaskListCriteria
{
    public function __construct(
        public ?string $userId = null,
        public string $search = '',
        public ?string $status = null,
        public string $sort = 'createdAt',
        public string $direction = 'desc',
        public int $page = 1,
        public int $perPage = 20,
    ) {
    }
}
