<?php

declare(strict_types=1);

namespace App\Review\Infrastructure\Persistence\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\Entity\WeeklyReview;
use App\Review\Domain\Repository\WeeklyReviewRepositoryInterface;
use App\Review\Domain\ValueObject\WeeklyReviewId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

final readonly class DoctrineWeeklyReviewRepository implements WeeklyReviewRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        WeeklyReview $weeklyReview,
    ): void {
        $this->entityManager->persist(
            $weeklyReview,
        );

        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function findById(
        WeeklyReviewId $id,
    ): ?WeeklyReview {
        return $this->entityManager->find(
            WeeklyReview::class,
            $id,
        );
    }

    public function findByUserId(
        UserId $userId,
    ): array {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('r')
            ->from(
                WeeklyReview::class,
                'r',
            )
            ->andWhere(
                'r.userId = :userId',
            )
            ->setParameter(
                'userId',
                $userId,
            )
            ->orderBy(
                'r.weekStartDate',
                'DESC',
            )
            ->getQuery()
            ->getResult();
    }

    public function findByWeekStartDate(
        UserId $userId,
        \DateTimeImmutable $weekStartDate,
    ): ?WeeklyReview {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('r')
            ->from(
                WeeklyReview::class,
                'r',
            )
            ->andWhere(
                'r.userId = :userId',
            )
            ->andWhere(
                'r.weekStartDate = :weekStartDate',
            )
            ->setParameter(
                'userId',
                $userId,
            )
            ->setParameter(
                'weekStartDate',
                $weekStartDate,
            )
            ->getQuery()
            ->getOneOrNullResult();
    }
}
