<?php

declare(strict_types=1);

namespace App\Inbox\Application\DTO;

use App\Area\Domain\ValueObject\AreaId;
use App\Inbox\Domain\ValueObject\InboxItemId;

final readonly class ProcessInboxItemInput
{
    public function __construct(
        public InboxItemId $inboxItemId,
        public AreaId $areaId,
        public string $title,
        public string $nextAction,
        public int $estimatedMinutes,
    ) {
    }
}
