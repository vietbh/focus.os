<?php

declare(strict_types=1);

namespace App\Workspace\Application\Query;

use App\Workspace\Application\DTO\WorkspaceSummaryDto;
use Knp\Component\Pager\Pagination\PaginationInterface;

interface WorkspaceQueryInterface
{
    public function paginate(
        WorkspaceListCriteria $criteria,
    ): PaginationInterface;

    /**
     * @return WorkspaceSummaryDto[]
     */
    public function list(): array;

    /**
     * @return WorkspaceSummaryDto[]
     */
    public function listByOwner(
        string $ownerId,
    ): array;
}
