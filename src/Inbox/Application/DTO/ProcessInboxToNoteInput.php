<?php

declare(strict_types=1);

namespace App\Inbox\Application\DTO;

use App\Inbox\Domain\ValueObject\InboxItemId;

final readonly class ProcessInboxToNoteInput
{
    public function __construct(
        public InboxItemId $inboxItemId,
        public string $title,
    ) {
    }
}
