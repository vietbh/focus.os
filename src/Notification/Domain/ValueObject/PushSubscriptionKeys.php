<?php

declare(strict_types=1);

namespace App\Notification\Domain\ValueObject;

final readonly class PushSubscriptionKeys
{
    public function __construct(
        private string $endpoint,
        private string $publicKey,
        private string $authToken,
    ) {
    }

    public function endpoint(): string
    {
        return $this->endpoint;
    }

    public function publicKey(): string
    {
        return $this->publicKey;
    }

    public function authToken(): string
    {
        return $this->authToken;
    }
}
