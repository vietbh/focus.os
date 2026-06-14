<?php

declare(strict_types=1);

namespace App\Note\Domain\Entity;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Domain\ValueObject\NoteId;

final class Note
{
    public function __construct(
        private NoteId $id,
        private UserId $userId,
        private string $title,
        private ?string $content,
        private \DateTimeImmutable $createdAt,
        private \DateTimeImmutable $updatedAt,
    ) {
    }

    public static function create(
        NoteId $id,
        UserId $userId,
        string $title,
        ?string $content,
        \DateTimeImmutable $createdAt,
    ): self {
        if (trim($title) === '') {
            throw new \InvalidArgumentException(
                'Note title cannot be empty.',
            );
        }

        return new self(
            id: $id,
            userId: $userId,
            title: $title,
            content: $content,
            createdAt: $createdAt,
            updatedAt: $createdAt,
        );
    }

    public function update(
        string $title,
        ?string $content,
        \DateTimeImmutable $updatedAt,
    ): void {
        if (trim($title) === '') {
            throw new \InvalidArgumentException(
                'Note title cannot be empty.',
            );
        }

        $this->title = $title;
        $this->content = $content;
        $this->updatedAt = $updatedAt;
    }

    public function ownedBy(
        UserId $userId,
    ): bool {
        return $this->userId->equals(
            $userId,
        );
    }

    public function id(): NoteId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): ?string
    {
        return $this->content;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
