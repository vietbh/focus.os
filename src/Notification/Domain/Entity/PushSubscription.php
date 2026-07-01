<?php

declare(strict_types=1);

namespace App\Notification\Domain\Entity;

use App\Identity\Domain\ValueObject\UserId;
use App\Notification\Domain\ValueObject\PushSubscriptionId;
use App\Notification\Domain\ValueObject\PushSubscriptionKeys;

final class PushSubscription
{
    public function __construct(
        private readonly PushSubscriptionId $id,
        private readonly UserId                                                  $userId,
        private string $endpoint,
        private string $publicKey,
        private string $authToken,
        private readonly \DateTimeImmutable                                      $createdAt,
        private ?\DateTimeImmutable                                              $updatedAt = null,
    ) {
    }

    public static function subscribe(
        PushSubscriptionId $id,
        UserId                                                  $userId,
        PushSubscriptionKeys                                    $keys,
    ): self {
        return new self(
            id: $id,
            userId: $userId,
            endpoint: $keys->endpoint(),
            publicKey: $keys->publicKey(),
            authToken: $keys->authToken(),
            createdAt: new \DateTimeImmutable(),
        );
    }

    public function id(): PushSubscriptionId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function keys(): PushSubscriptionKeys
    {
        return new PushSubscriptionKeys(
            endpoint: $this->endpoint,
            publicKey: $this->publicKey,
            authToken: $this->authToken,
        );
    }

    public function update(
        PushSubscriptionKeys $keys,
    ): void {
        $this->endpoint = $keys->endpoint();
        $this->publicKey = $keys->publicKey();
        $this->authToken = $keys->authToken();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
