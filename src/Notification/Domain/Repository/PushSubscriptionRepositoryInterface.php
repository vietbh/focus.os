<?php

declare(strict_types=1);

namespace App\Notification\Domain\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Notification\Domain\Entity\PushSubscription;

interface PushSubscriptionRepositoryInterface
{
    public function save(
        PushSubscription $subscription,
    ): void;

    public function remove(
        PushSubscription $subscription,
    ): void;

    public function flush(): void;

    public function findByUser(
        UserId $userId,
    ): array;

    public function findByEndpoint(
        string $endpoint,
    ): ?PushSubscription;
}
