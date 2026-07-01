<?php

declare(strict_types=1);

namespace App\Notification\Infrastructure\Persistence\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Notification\Domain\Entity\PushSubscription;
use App\Notification\Domain\Repository\PushSubscriptionRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrinePushSubscriptionRepository implements PushSubscriptionRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        PushSubscription $subscription,
    ): void {
        $this->entityManager->persist($subscription);
        $this->flush();
    }

    public function remove(
        PushSubscription $subscription,
    ): void {
        $this->entityManager->remove($subscription);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function findByEndpoint(
        string $endpoint,
    ): ?PushSubscription {
        return $this->entityManager
            ->getRepository(PushSubscription::class)
            ->findOneBy([
                'endpoint' => $endpoint,
            ]);
    }

    public function findByUser(
        UserId $userId,
    ): array {
        return $this->entityManager
            ->getRepository(PushSubscription::class)
            ->findBy(
                [
                    'userId' => $userId->value(),
                ],
                [
                    'createdAt' => 'DESC',
                ],
            );
    }
}
