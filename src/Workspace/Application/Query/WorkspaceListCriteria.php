<?php

declare(strict_types=1);

namespace App\Workspace\Application\Query;

use App\Identity\Domain\ValueObject\UserId;

final class WorkspaceListCriteria
{
    public function __construct(
        public ?UserId $ownerId = null,
        public string $search = '',
        public int $page = 1,
        public int $perPage = 20,
        public string $sort = 'createdAt',
        public string $direction = 'DESC',
    ) {
    }
}
