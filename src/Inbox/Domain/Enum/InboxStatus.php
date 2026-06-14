<?php

declare(strict_types=1);

namespace App\Inbox\Domain\Enum;

enum InboxStatus: string
{
    case NEW = 'NEW';

    case PROCESSED = 'PROCESSED';
}
