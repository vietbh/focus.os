<?php

declare(strict_types=1);

namespace App\Review\Infrastructure\Persistence\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\Entity\MonthlyReview;
use App\Review\Domain\Repository\MonthlyReviewRepositoryInterface;
use App\Review\Domain\ValueObject\MonthlyReviewId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

final readonly class DoctrineMonthlyReviewRepository implements MonthlyReviewRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        MonthlyReview $monthlyReview,
    ): void {
        $this->entityManager->persist(
            $monthlyReview,
        );

        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function findById(
        MonthlyReviewId $id,
    ): ?MonthlyReview {
        return $this->entityManager->find(
            MonthlyReview::class,
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
                MonthlyReview::class,
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
                'r.month',
                'DESC',
            )
            ->getQuery()
            ->getResult();
    }

    public function findByMonth(
        UserId $userId,
        \DateTimeImmutable $month,
    ): ?MonthlyReview {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('r')
            ->from(
                MonthlyReview::class,
                'r',
            )
            ->andWhere(
                'r.userId = :userId',
            )
            ->andWhere(
                'r.month = :month',
            )
            ->setParameter(
                'userId',
                $userId,
            )
            ->setParameter(
                'month',
                $month,
            )
            ->getQuery()
            ->getOneOrNullResult();
    }
}
