<?php

declare(strict_types=1);

namespace App\Inbox\Domain\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Inbox\Domain\Entity\InboxItem;
use App\Inbox\Domain\ValueObject\InboxItemId;

interface InboxItemRepositoryInterface
{
    public function save(
        InboxItem $item,
    ): void;

    public function findById(
        InboxItemId $id,
    ): ?InboxItem;

    /**
     * @return InboxItem[]
     */
    public function findNewItems(
        UserId $userId,
    ): array;

    /**
     * @return InboxItem[]
     */
    public function findProcessedItems(
        UserId $userId,
    ): array;

    public function countNewItems(
        UserId $userId,
    ): int;
}
