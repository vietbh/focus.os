<?php

declare(strict_types=1);

namespace App\Goal\Infrastructure\Persistence\Query;

use App\Goal\Application\Query\GoalListCriteria;
use App\Goal\Application\Query\GoalQueryInterface;
use App\Goal\Domain\Entity\Goal;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

final readonly class DoctrineGoalQuery implements GoalQueryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PaginatorInterface $paginator,
    ) {
    }

    public function paginate(
        GoalListCriteria $criteria,
    ): PaginationInterface {

        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('g')
            ->from(Goal::class, 'g');

        if ($criteria->userId !== null) {
            $qb
                ->andWhere('g.userId = :userId')
                ->setParameter('userId', $criteria->userId);
        }

        if ($criteria->search !== '') {
            $qb
                ->andWhere(
                    '(g.title LIKE :search OR g.description LIKE :search)'
                )
                ->setParameter(
                    'search',
                    '%' . $criteria->search . '%'
                );
        }

        if ($criteria->status !== null) {
            $qb
                ->andWhere('g.status = :status')
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
            sprintf('g.%s', $sort),
            $direction
        );

        return $this->paginator->paginate(
            $qb,
            $criteria->page,
            $criteria->perPage,
        );
    }
}
