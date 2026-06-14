<?php

declare(strict_types=1);

namespace App\Area\Domain\Entity;

use App\Area\Domain\ValueObject\AreaId;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;

final class Area
{
    public function __construct(
        private AreaId $id,
        private UserId $userId,
        private ?GoalId $goalId,
        private string $name,
        private \DateTimeImmutable $createdAt,
        private \DateTimeImmutable $updatedAt,
    ) {
    }

    public static function create(
        AreaId $id,
        UserId $userId,
        ?GoalId $goalId,
        string $name,
        \DateTimeImmutable $createdAt,
    ): self {
        return new self(
            $id,
            $userId,
            $goalId,
            $name,
            $createdAt,
            $createdAt,
        );
    }

    public function rename(
        string $name,
        \DateTimeImmutable $updatedAt,
    ): void {
        if (trim($name) === '') {
            throw new \InvalidArgumentException(
                'Area name cannot be empty.',
            );
        }
        $this->name = $name;
        $this->updatedAt = $updatedAt;
    }

    public function id(): AreaId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function ownedBy(
        UserId $userId,
    ): bool {
        return $this->userId->equals(
            $userId,
        );
    }

    public function goalId(): ?GoalId
    {
        return $this->goalId;
    }

    public function update(
        string $name,
        ?GoalId $goalId,
    ): void {
        $this->name = $name;
        $this->goalId = $goalId;
    }

    public function removeGoal(): void
    {
        $this->goalId = null;
    }

}
