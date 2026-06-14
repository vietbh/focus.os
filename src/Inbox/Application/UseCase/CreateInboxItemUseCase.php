<?php

declare(strict_types=1);

namespace App\Inbox\Application\UseCase;

use App\Inbox\Application\DTO\CreateInboxItemInput;
use App\Inbox\Domain\Entity\InboxItem;
use App\Inbox\Domain\Repository\InboxItemRepositoryInterface;
use App\Inbox\Domain\ValueObject\InboxItemId;
use Symfony\Component\Uid\Uuid;

final readonly class CreateInboxItemUseCase
{
    public function __construct(
        private InboxItemRepositoryInterface $items,
    ) {
    }

    public function execute(
        CreateInboxItemInput $input,
    ): InboxItem {
        $item = InboxItem::create(
            id: InboxItemId::fromString(
                Uuid::v7()->toRfc4122(),
            ),
            userId: $input->userId,
            content: $input->content,
            createdAt: new \DateTimeImmutable(),
        );

        $this->items->save(
            $item,
        );

        return $item;
    }
}
