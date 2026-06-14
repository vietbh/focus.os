<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence\Repository;

use App\Area\Domain\ValueObject\AreaId;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\Entity\Task;
use App\Task\Domain\Enum\TaskStatus;
use App\Task\Domain\Repository\TaskRepositoryInterface;
use App\Task\Domain\ValueObject\TaskId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

final readonly class DoctrineTaskRepository implements TaskRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        Task $task,
    ): void {
        $this->entityManager->persist(
            $task,
        );

        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function findById(
        TaskId $id,
    ): ?Task {
        return $this->entityManager->find(
            Task::class,
            $id,
        );
    }

    public function findByUserId(
        UserId $userId,
    ): array {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('t')
            ->from(Task::class, 't')
            ->andWhere('t.userId = :userId')
            ->setParameter(
                'userId',
                $userId,
            )
            ->orderBy(
                't.createdAt',
                'DESC',
            )
            ->getQuery()
            ->getResult();
    }

    public function findOneByUserIdAndStatus(
        UserId $userId,
        TaskStatus $status,
    ): ?Task {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('t')
            ->from(Task::class, 't')
            ->andWhere('t.userId = :userId')
            ->andWhere('t.status = :status')
            ->setParameter(
                'userId',
                $userId,
            )
            ->setParameter(
                'status',
                $status,
            )
            ->setMaxResults(
                1,
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findDoingTask(
        UserId $userId,
    ): ?Task {
        return $this->findOneByUserIdAndStatus(
            $userId,
            TaskStatus::DOING,
        );
    }

    public function countByAreaId(
        AreaId $areaId,
    ): int {
        return (int) $this->entityManager
            ->createQueryBuilder()
            ->select('COUNT(t.id)')
            ->from(Task::class, 't')
            ->andWhere('t.areaId = :areaId')
            ->setParameter(
                'areaId',
                $areaId,
            )
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countActiveTasks(
        UserId $userId,
    ): int {
        return (int) $this->entityManager
            ->createQueryBuilder()
            ->select('COUNT(t.id)')
            ->from(Task::class, 't')
            ->andWhere('t.userId = :userId')
            ->andWhere('t.status != :status')
            ->setParameter(
                'userId',
                $userId,
            )
            ->setParameter(
                'status',
                TaskStatus::DONE,
            )
            ->getQuery()
            ->getSingleScalarResult();
    }
}
