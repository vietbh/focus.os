<?php

declare(strict_types=1);

namespace App\Inbox\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Inbox\Domain\Repository\InboxItemRepositoryInterface;

final readonly class GetInboxListUseCase
{
    public function __construct(
        private InboxItemRepositoryInterface $items,
    ) {
    }

    public function execute(
        string $userId,
    ): array {
        return $this->items->findNewItems(
            UserId::fromString($userId),
        );
    }
}
