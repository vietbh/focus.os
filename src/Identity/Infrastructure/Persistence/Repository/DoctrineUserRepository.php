<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\Persistence\Repository;

use App\Identity\Domain\Entity\User;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

final readonly class DoctrineUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        User $user,
    ): void {
        $this->entityManager->persist(
            $user,
        );
        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function findById(
        UserId $id,
    ): ?User {
        return $this->entityManager->find(
            User::class,
            $id,
        );
    }

    public function findByProvider(
        string $providerId,
    ): ?User {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->andWhere('u.providerId = :providerId')
            ->setParameter(
                'providerId',
                $providerId,
            )
            ->getQuery()
            ->getOneOrNullResult();
    }
}
