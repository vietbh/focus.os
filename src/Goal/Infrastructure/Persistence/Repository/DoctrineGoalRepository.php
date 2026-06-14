<?php

declare(strict_types=1);

namespace App\Goal\Infrastructure\Persistence\Repository;

use App\Goal\Domain\Entity\Goal;
use App\Goal\Domain\Enum\GoalStatus;
use App\Goal\Domain\Repository\GoalRepositoryInterface;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

final readonly class DoctrineGoalRepository implements GoalRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        Goal $goal,
    ): void {
        $this->entityManager->persist(
            $goal,
        );

        $this->entityManager->flush();
    }

    public function remove(
        Goal $goal,
    ): void {
        $this->entityManager->remove(
            $goal,
        );

        $this->entityManager->flush();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(
        GoalId $id,
    ): ?Goal {
        return $this->entityManager->find(
            Goal::class,
            $id,
        );
    }

    public function findByUserId(
        UserId $userId,
    ): array {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('g')
            ->from(Goal::class, 'g')
            ->andWhere('g.userId = :userId')
            ->setParameter(
                'userId',
                $userId,
            )
            ->orderBy(
                'g.updatedAt',
                'DESC',
            )
            ->getQuery()
            ->getResult();
    }

    public function findByUserIdAndStatus(
        UserId $userId,
        GoalStatus $status,
    ): array {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('g')
            ->from(Goal::class, 'g')
            ->andWhere('g.userId = :userId')
            ->andWhere('g.status = :status')
            ->setParameter(
                'userId',
                $userId,
            )
            ->setParameter(
                'status',
                $status,
            )
            ->orderBy(
                'g.updatedAt',
                'DESC',
            )
            ->getQuery()
            ->getResult();
    }

    public function countActiveGoals(
        UserId $userId,
    ): int {
        return (int) $this->entityManager
            ->createQueryBuilder()
            ->select('COUNT(g.id)')
            ->from(Goal::class, 'g')
            ->andWhere('g.userId = :userId')
            ->andWhere('g.status = :status')
            ->setParameter(
                'userId',
                $userId,
            )
            ->setParameter(
                'status',
                GoalStatus::ACTIVE,
            )
            ->getQuery()
            ->getSingleScalarResult();
    }
}
