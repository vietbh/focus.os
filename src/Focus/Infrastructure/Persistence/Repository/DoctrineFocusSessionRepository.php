<?php

declare(strict_types=1);

namespace App\Focus\Infrastructure\Persistence\Repository;

use App\Focus\Domain\Entity\FocusSession;
use App\Focus\Domain\Repository\FocusSessionRepositoryInterface;
use App\Focus\Domain\ValueObject\FocusSessionId;
use App\Identity\Domain\ValueObject\UserId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

final readonly class DoctrineFocusSessionRepository implements FocusSessionRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        FocusSession $session,
    ): void {
        $this->entityManager->persist($session);
        $this->entityManager->flush();
    }

    public function remove(
        FocusSession $session,
    ): void {
        $this->entityManager->remove($session);
    }

    public function ofId(
        FocusSessionId $id,
    ): ?FocusSession {
        return $this->entityManager->find(
            FocusSession::class,
            $id,
        );
    }
    private function queryBuilder(): QueryBuilder
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('session')
            ->from(FocusSession::class, 'session');
    }
    public function activeSessionOfUser(
        UserId $userId,
    ): ?FocusSession {
        return $this->queryBuilder()
            ->where('session.userId = :userId')
            ->andWhere('session.status IN (:statuses)')
            ->setParameter('userId', $userId)
            ->setParameter('statuses', [
                'ACTIVE',
                'PAUSED',
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
