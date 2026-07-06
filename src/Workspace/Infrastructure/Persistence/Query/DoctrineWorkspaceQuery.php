<?php

declare(strict_types=1);

namespace App\Workspace\Infrastructure\Persistence\Query;

use App\Identity\Domain\ValueObject\UserId;
use App\Workspace\Application\Dto\WorkspaceSummaryDto;
use App\Workspace\Application\Query\WorkspaceListCriteria;
use App\Workspace\Application\Query\WorkspaceQueryInterface;
use App\Workspace\Domain\Entity\Workspace;
use App\Workspace\Domain\ValueObject\WorkspaceId;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

final readonly class DoctrineWorkspaceQuery implements WorkspaceQueryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PaginatorInterface $paginator,
    ) {
    }

    public function paginate(
        WorkspaceListCriteria $criteria,
    ): PaginationInterface {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('w')
            ->from(Workspace::class, 'w');

        if ($criteria->ownerId !== null) {
            $qb
                ->andWhere('w.ownerId = :ownerId')
                ->setParameter(
                    'ownerId',
                    $criteria->ownerId,
                );
        }

        if ($criteria->search !== '') {
            $qb
                ->andWhere(
                    '(w.name.value LIKE :search OR w.description LIKE :search)'
                )
                ->setParameter(
                    'search',
                    '%'.$criteria->search.'%',
                );
        }

        $allowedSorts = [
            'name',
            'createdAt',
            'updatedAt',
        ];

        $sort = in_array(
            $criteria->sort,
            $allowedSorts,
            true,
        )
            ? $criteria->sort
            : 'createdAt';

        $direction = strtolower($criteria->direction) === 'asc'
            ? 'ASC'
            : 'DESC';

        $qb->orderBy(
            sprintf(
                'w.%s',
                $sort,
            ),
            $direction,
        );

        return $this->paginator->paginate(
            $qb,
            $criteria->page,
            $criteria->perPage,
        );
    }

    public function list(): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('w')
            ->from(Workspace::class, 'w')
            ->orderBy('w.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function listByOwner(
        string $ownerId,
    ): array {
        return $this->entityManager
            ->createQueryBuilder()
            ->select(sprintf(
                'NEW %s(
                w.id,
                w.name,
                w.description,
                w.icon,
                w.color,
                false
            )',
                WorkspaceSummaryDto::class,
            ))
            ->from(Workspace::class, 'w')
            ->where('w.ownerId = :ownerId')
            ->setParameter('ownerId', $ownerId)
            ->orderBy('w.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
