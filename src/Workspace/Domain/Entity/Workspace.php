<?php

declare(strict_types=1);

namespace App\Workspace\Domain\Entity;

use App\Identity\Domain\ValueObject\UserId;
use App\Workspace\Domain\ValueObject\WorkspaceId;

class Workspace
{
    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $updatedAt;

    public function __construct(
        private readonly WorkspaceId $id,
        private readonly UserId $ownerId,
        private string $name,
        private ?string $description = null,
        private ?string $icon = null,
        private ?string $color = null,
    ) {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = $this->createdAt;
    }

    public function id(): WorkspaceId
    {
        return $this->id;
    }

    public function ownerId(): UserId
    {
        return $this->ownerId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function icon(): ?string
    {
        return $this->icon;
    }

    public function color(): ?string
    {
        return $this->color;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function rename(
        string $name,
    ): void {
        if ($this->name == $name) {
            return;
        }

        $this->name = $name;

        $this->touch();
    }

    public function changeDescription(
        ?string $description,
    ): void {
        $description = $description !== null
            ? trim($description)
            : null;

        if ($description === '') {
            $description = null;
        }

        if ($this->description === $description) {
            return;
        }

        $this->description = $description;

        $this->touch();
    }

    public function changeAppearance(
        ?string $icon,
        ?string $color,
    ): void {
        $icon = $icon !== null ? trim($icon) : null;
        $color = $color !== null ? trim($color) : null;

        if (
            $this->icon === $icon
            && $this->color === $color
        ) {
            return;
        }

        $this->icon = $icon;
        $this->color = $color;

        $this->touch();
    }

    private function touch(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
