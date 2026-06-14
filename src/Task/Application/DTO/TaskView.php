<?php

namespace App\Task\Application\DTO;

final readonly class TaskView
{
    public function __construct(
        public string $id,
        public string $title,
        public string $nextAction,
        public string $status,
    ) {}
}
