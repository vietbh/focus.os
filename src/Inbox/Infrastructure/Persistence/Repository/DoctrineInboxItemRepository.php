<?php

declare(strict_types=1);

namespace App\Inbox\Infrastructure\Persistence\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Inbox\Domain\Entity\InboxItem;
use App\Inbox\Domain\Enum\InboxStatus;
use App\Inbox\Domain\Repository\InboxItemRepositoryInterface;
use App\Inbox\Domain\ValueObject\InboxItemId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

final readonly class DoctrineInboxItemRepository implements InboxItemRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        InboxItem $item,
    ): void {
        $this->entityManager->persist(
            $item,
        );

        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function findById(
        InboxItemId $id,
    ): ?InboxItem {
        return $this->entityManager->find(
            InboxItem::class,
            $id,
        );
    }

    public function findNewItems(
        UserId $userId,
    ): array {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('i')
            ->from(InboxItem::class, 'i')
            ->andWhere('i.userId = :userId')
            ->andWhere('i.status = :status')
            ->setParameter(
                'userId',
                $userId,
            )
            ->setParameter(
                'status',
                InboxStatus::NEW,
            )
            ->orderBy(
                'i.createdAt',
                'DESC',
            )
            ->getQuery()
            ->getResult();
    }

    public function findProcessedItems(
        UserId $userId,
    ): array {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('i')
            ->from(InboxItem::class, 'i')
            ->andWhere('i.userId = :userId')
            ->andWhere('i.status = :status')
            ->setParameter(
                'userId',
                $userId,
            )
            ->setParameter(
                'status',
                InboxStatus::PROCESSED,
            )
            ->orderBy(
                'i.createdAt',
                'DESC',
            )
            ->getQuery()
            ->getResult();
    }

    public function countNewItems(
        UserId $userId,
    ): int {
        return (int) $this->entityManager
            ->createQueryBuilder()
            ->select('COUNT(i.id)')
            ->from(InboxItem::class, 'i')
            ->andWhere('i.userId = :userId')
            ->andWhere('i.status = :status')
            ->setParameter(
                'userId',
                $userId,
            )
            ->setParameter(
                'status',
                InboxStatus::NEW,
            )
            ->getQuery()
            ->getSingleScalarResult();
    }
}
