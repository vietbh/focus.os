<?php

declare(strict_types=1);

namespace App\Area\Infrastructure\Persistence\Query;

use App\Area\Application\Query\AreaListCriteria;
use App\Area\Application\Query\AreaQueryInterface;
use App\Area\Domain\Entity\Area;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

final readonly class DoctrineAreaQuery implements AreaQueryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PaginatorInterface $paginator,
    ) {
    }

    public function paginate(
        AreaListCriteria $criteria,
    ): PaginationInterface {

        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('a')
            ->from(Area::class, 'a');

        if ($criteria->userId !== null) {
            $qb
                ->andWhere('a.userId = :userId')
                ->setParameter('userId', $criteria->userId);
        }

        if ($criteria->search !== '') {
            $qb
                ->andWhere(
                    '(a.title LIKE :search OR a.description LIKE :search)'
                )
                ->setParameter(
                    'search',
                    '%' . $criteria->search . '%'
                );
        }

        if ($criteria->status !== null) {
            $qb
                ->andWhere('a.status = :status')
                ->setParameter('status', $criteria->status);
        }

        $allowedSorts = [
            'title',
            'status',
            'createdAt',
            'updatedAt',
        ];

        $sort = in_array(
            $criteria->sort,
            $allowedSorts,
            true
        )
            ? $criteria->sort
            : 'createdAt';

        $direction = strtolower($criteria->direction) === 'asc'
            ? 'ASC'
            : 'DESC';

        $qb->orderBy(
            sprintf('a.%s', $sort),
            $direction
        );

        return $this->paginator->paginate(
            $qb,
            $criteria->page,
            $criteria->perPage,
        );
    }
}
