<?php

declare(strict_types=1);

namespace App\Area\Infrastructure\Persistence\Repository;

use App\Area\Domain\Entity\Area;
use App\Area\Domain\Repository\AreaRepositoryInterface;
use App\Area\Domain\ValueObject\AreaId;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(AreaRepositoryInterface::class)]
final readonly class DoctrineAreaRepository implements AreaRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        Area $area,
    ): void {
        $this->entityManager->persist(
            $area,
        );

        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function findById(
        AreaId $id,
    ): ?Area {
        return $this->entityManager->find(
            Area::class,
            $id,
        );
    }

    public function findByUserId(
        UserId $userId,
    ): array {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('a')
            ->from(Area::class, 'a')
            ->andWhere('a.userId = :userId')
            ->setParameter(
                'userId',
                $userId,
            )
            ->orderBy(
                'a.createdAt',
                'ASC',
            )
            ->getQuery()
            ->getResult();
    }

    public function countByUserId(
        UserId $userId,
    ): int {
        return $this->entityManager
            ->getRepository(
                Area::class,
            )
            ->count(
                [
                    'userId' => $userId,
                ],
            );
    }

    public function remove(
        Area $area,
    ): void {
        $this->entityManager->remove(
            $area,
        );

        $this->entityManager->flush();
    }

    public function findByGoalId(
        GoalId $goalId,
    ): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('a')
            ->from(
                Area::class,
                'a',
            )
            ->andWhere(
                'a.goalId = :goalId',
            )
            ->setParameter(
                'goalId',
                $goalId,
            )
            ->getQuery()
            ->getResult();
    }
}
