<?php

declare(strict_types=1);

namespace App\Workspace\Application\UseCase;

use App\Identity\Application\Service\CurrentUserProviderInterface;
use App\Workspace\Application\Query\WorkspaceListCriteria;
use App\Workspace\Application\Query\WorkspaceQueryInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

final readonly class GetWorkspaceListUseCase
{
    public function __construct(
        private WorkspaceQueryInterface $query,
        private CurrentUserProviderInterface $currentUserProvider,
    ) {
    }

    public function execute(
        WorkspaceListCriteria $criteria,
    ): PaginationInterface {
        $criteria->ownerId = $this
            ->currentUserProvider
            ->current()
            ->id();

        return $this->query->paginate(
            $criteria,
        );
    }
}
