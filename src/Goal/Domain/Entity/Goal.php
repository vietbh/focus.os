<?php

declare(strict_types=1);

namespace App\Goal\Domain\Entity;

use App\Goal\Domain\Enum\GoalStatus;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;

final class Goal
{
    public function __construct(
        private GoalId $id,
        private UserId $userId,
        private string $title,
        private ?string $description,
        private ?\DateTimeImmutable $targetDate,
        private GoalStatus $status,
        private \DateTimeImmutable $createdAt,
        private \DateTimeImmutable $updatedAt,
    ) {
    }

    public static function create(
        GoalId $id,
        UserId $userId,
        string $title,
        ?string $description,
        ?\DateTimeImmutable $targetDate,
        \DateTimeImmutable $createdAt,
    ): self {
        if (trim($title) === '') {
            throw new \InvalidArgumentException(
                'Goal title cannot be empty.',
            );
        }

        return new self(
            id: $id,
            userId: $userId,
            title: $title,
            description: $description,
            targetDate: $targetDate,
            status: GoalStatus::ACTIVE,
            createdAt: $createdAt,
            updatedAt: $createdAt,
        );
    }

    public function update(
        string $title,
        ?string $description,
        ?\DateTimeImmutable $targetDate,
        \DateTimeImmutable $updatedAt,
    ): void {
        if (trim($title) === '') {
            throw new \InvalidArgumentException(
                'Goal title cannot be empty.',
            );
        }

        $this->title = $title;
        $this->description = $description;
        $this->targetDate = $targetDate;
        $this->updatedAt = $updatedAt;
    }

    public function complete(
        \DateTimeImmutable $updatedAt,
    ): void {
        $this->status = GoalStatus::COMPLETED;
        $this->updatedAt = $updatedAt;
    }

    public function cancel(
        \DateTimeImmutable $updatedAt,
    ): void {
        $this->status = GoalStatus::CANCELLED;
        $this->updatedAt = $updatedAt;
    }

    public function ownedBy(
        UserId $userId,
    ): bool {
        return $this->userId->equals(
            $userId,
        );
    }

    public function id(): GoalId
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

    public function description(): ?string
    {
        return $this->description;
    }

    public function targetDate(): ?\DateTimeImmutable
    {
        return $this->targetDate;
    }

    public function status(): GoalStatus
    {
        return $this->status;
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
