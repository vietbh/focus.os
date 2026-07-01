<?php

declare(strict_types=1);

namespace App\Focus\Infrastructure\Persistence\Query;

use App\Focus\Application\DTO\FocusSessionDto;
use App\Focus\Application\Mapper\FocusSessionMapper;
use App\Focus\Application\QueryRepository\FocusAnalyticsQueryInterface;
use App\Focus\Domain\Entity\FocusSession;
use App\Focus\Domain\Enum\FocusSessionStatus;
use App\Identity\Domain\ValueObject\UserId;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineFocusAnalyticsQuery implements FocusAnalyticsQueryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FocusSessionMapper $mapper,
    ) {
    }

    public function currentOfUser(
        UserId $userId,
    ): ?FocusSessionDto {
        /** @var FocusSession|null $session */
        $session = $this->entityManager
            ->createQueryBuilder()
            ->select('session')
            ->from(FocusSession::class, 'session')
            ->where('session.userId = :userId')
            ->andWhere('session.status IN (:statuses)')
            ->setParameter('userId', $userId)
            ->setParameter('statuses', [
                FocusSessionStatus::ACTIVE,
                FocusSessionStatus::PAUSED,
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if ($session === null) {
            return null;
        }

        return $this->mapper->toDto($session);
    }

    public function history(UserId $userId, int $limit = 30,): array
    {
        // TODO: Implement history() method.
    }
}
