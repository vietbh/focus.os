<?php

declare(strict_types=1);

namespace App\Workspace\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Workspace\Application\Query\WorkspaceListCriteria;
use App\Workspace\Application\Query\WorkspaceQueryInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class GetWorkspaceListUseCase
{
    public function __construct(
        private WorkspaceQueryInterface $query,
        private Security $security,
    ) {
    }

    public function execute(
        WorkspaceListCriteria $criteria,
    ): PaginationInterface {
        $criteria->ownerId = UserId::fromString(
            $this
                ->security
                ->getUser()
                ->getUserIdentifier()
        );

        return $this->query->paginate(
            $criteria,
        );
    }
}
