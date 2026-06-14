<?php

declare(strict_types=1);

namespace App\Note\Infrastructure\Persistence\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Domain\Entity\Note;
use App\Note\Domain\Repository\NoteRepositoryInterface;
use App\Note\Domain\ValueObject\NoteId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

final readonly class DoctrineNoteRepository implements NoteRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        Note $note,
    ): void {
        $this->entityManager->persist(
            $note,
        );

        $this->entityManager->flush();
    }

    public function remove(
        Note $note,
    ): void {
        $this->entityManager->remove(
            $note,
        );

        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function findById(
        NoteId $id,
    ): ?Note {
        return $this->entityManager->find(
            Note::class,
            $id,
        );
    }

    public function findByUserId(
        UserId $userId,
    ): array {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('n')
            ->from(Note::class, 'n')
            ->andWhere('n.userId = :userId')
            ->setParameter(
                'userId',
                $userId,
            )
            ->orderBy(
                'n.updatedAt',
                'DESC',
            )
            ->getQuery()
            ->getResult();
    }

    public function findRecentByUserId(
        UserId $userId,
        int $limit = 5,
    ): array {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('n')
            ->from(Note::class, 'n')
            ->andWhere('n.userId = :userId')
            ->setParameter(
                'userId',
                $userId,
            )
            ->orderBy(
                'n.updatedAt',
                'DESC',
            )
            ->setMaxResults(
                $limit,
            )
            ->getQuery()
            ->getResult();
    }



}
