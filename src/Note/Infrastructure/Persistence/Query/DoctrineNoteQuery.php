<?php

declare(strict_types=1);

namespace App\Note\Infrastructure\Persistence\Query;

use App\Area\Application\Query\AreaListCriteria;
use App\Area\Domain\Entity\Area;
use App\Note\Application\Query\NoteListCriteria;
use App\Note\Application\Query\NoteQueryInterface;
use App\Note\Domain\Entity\Note;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

final readonly class DoctrineNoteQuery implements NoteQueryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PaginatorInterface $paginator,
    ) {
    }

    public function paginate(
        NoteListCriteria $criteria,
    ): PaginationInterface {

        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('n')
            ->from(Note::class, 'n');

        if ($criteria->userId !== null) {
            $qb
                ->andWhere('n.userId = :userId')
                ->setParameter('userId', $criteria->userId);
        }

        if ($criteria->search !== '') {
            $qb
                ->andWhere(
                    '(n.title LIKE :search OR n.content LIKE :search)'
                )
                ->setParameter(
                    'search',
                    '%' . $criteria->search . '%'
                );
        }

        if ($criteria->status !== null) {
            $qb
                ->andWhere('n.status = :status')
                ->setParameter('status', $criteria->status);
        }

        $allowedSorts = [
            'title',
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
            sprintf('n.%s', $sort),
            $direction
        );

        return $this->paginator->paginate(
            $qb,
            $criteria->page,
            $criteria->perPage,
        );
    }
}
