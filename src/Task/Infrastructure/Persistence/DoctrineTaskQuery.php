<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence;

use App\Task\Application\Query\TaskListCriteria;
use App\Task\Application\Query\TaskQueryInterface;
use App\Task\Domain\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

final readonly class DoctrineTaskQuery implements TaskQueryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PaginatorInterface $paginator,
    ) {
    }

    public function paginate(
        TaskListCriteria $criteria,
    ): PaginationInterface {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('t')
            ->from(Task::class, 't');

        if ($criteria->userId !== null) {
            $qb
                ->andWhere('t.userId = :userId')
                ->setParameter('userId', $criteria->userId);
        }

        if ($criteria->search !== '') {
            $qb
                ->andWhere(
                    '(t.title LIKE :search OR t.description LIKE :search)'
                )
                ->setParameter(
                    'search',
                    '%' . $criteria->search . '%'
                );
        }

        if ($criteria->status !== null) {
            $qb
                ->andWhere('t.status = :status')
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
            sprintf('t.%s', $sort),
            $direction
        );

        return $this->paginator->paginate(
            $qb,
            $criteria->page,
            $criteria->perPage,
        );
    }
}
