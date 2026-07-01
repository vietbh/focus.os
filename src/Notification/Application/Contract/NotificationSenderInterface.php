<?php

declare(strict_types=1);

namespace App\Notification\Application\Contract;

use App\Identity\Domain\ValueObject\UserId;
use App\Notification\Application\ValueObject\NotificationMessage;

interface NotificationSenderInterface
{
    public function send(
        UserId $userId,
        NotificationMessage $message,
    ): void;
}
