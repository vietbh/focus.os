<?php

declare(strict_types=1);

namespace App\Notification\Application\Command;

use App\Identity\Domain\ValueObject\UserId;

final readonly class SubscribePushNotificationCommand
{
    public function __construct(
        public UserId $userId,
        public string $endpoint,
        public string $publicKey,
        public string $authToken,
    ) {
    }
}
