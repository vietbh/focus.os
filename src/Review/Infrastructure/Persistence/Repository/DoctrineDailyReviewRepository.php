<?php

declare(strict_types=1);

namespace App\Review\Infrastructure\Persistence\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Domain\Entity\DailyReview;
use App\Review\Domain\Repository\DailyReviewRepositoryInterface;
use App\Review\Domain\ValueObject\DailyReviewId;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineDailyReviewRepository implements DailyReviewRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        DailyReview $dailyReview,
    ): void {
        $this->entityManager->persist(
            $dailyReview,
        );

        $this->entityManager->flush();
    }

    public function findById(
        DailyReviewId $id,
    ): ?DailyReview {
        return $this->entityManager->find(
            DailyReview::class,
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
                DailyReview::class,
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
                'r.reviewDate',
                'DESC',
            )
            ->getQuery()
            ->getResult();
    }

    public function findByDate(
        UserId $userId,
        \DateTimeImmutable $reviewDate,
    ): ?DailyReview {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('r')
            ->from(
                DailyReview::class,
                'r',
            )
            ->andWhere(
                'r.userId = :userId',
            )
            ->andWhere(
                'r.reviewDate = :reviewDate',
            )
            ->setParameter(
                'userId',
                $userId,
            )
            ->setParameter(
                'reviewDate',
                $reviewDate,
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function hasReviewForDate(
        UserId $userId,
        \DateTimeImmutable $date,
    ): bool {
        return $this->findByDate(
                $userId,
                $date,
            ) !== null;
    }

}
