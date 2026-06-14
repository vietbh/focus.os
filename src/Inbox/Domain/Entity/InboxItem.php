<?php

declare(strict_types=1);

namespace App\Inbox\Domain\Entity;

use App\Identity\Domain\ValueObject\UserId;
use App\Inbox\Domain\Enum\InboxStatus;
use App\Inbox\Domain\ValueObject\InboxItemId;

final class InboxItem
{
    public function __construct(
        private InboxItemId $id,
        private UserId $userId,
        private string $content,
        private InboxStatus $status,
        private \DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $processedAt,
    ) {
    }

    public static function create(
        InboxItemId $id,
        UserId $userId,
        string $content,
        \DateTimeImmutable $createdAt,
    ): self {
        if (trim($content) === '') {
            throw new \InvalidArgumentException(
                'Inbox content cannot be empty.',
            );
        }

        return new self(
            id: $id,
            userId: $userId,
            content: $content,
            status: InboxStatus::NEW,
            createdAt: $createdAt,
            processedAt: null,
        );
    }

    public function markProcessed(
        \DateTimeImmutable $processedAt,
    ): void {
        if (
            $this->status === InboxStatus::PROCESSED
        ) {
            return;
        }

        $this->status = InboxStatus::PROCESSED;
        $this->processedAt = $processedAt;
    }

    public function id(): InboxItemId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function status(): InboxStatus
    {
        return $this->status;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function processedAt(): ?\DateTimeImmutable
    {
        return $this->processedAt;
    }

    public function ownedBy(
        UserId $userId,
    ): bool {
        return $this->userId->equals(
            $userId,
        );
    }
}
