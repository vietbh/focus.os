<?php

declare(strict_types=1);

namespace App\Identity\Domain\Entity;

use App\Identity\Domain\Enum\AuthProvider;
use App\Identity\Domain\ValueObject\UserId;

final class User
{
    public function __construct(
        private UserId $id,
        private string $email,
        private string $name,
        private ?string $avatar,
        private AuthProvider $provider,
        private string $providerId,
        private \DateTimeImmutable $createdAt,
        private \DateTimeImmutable $updatedAt,
    ) {
    }

    public static function create(
        UserId $id,
        string $email,
        string $name,
        ?string $avatar,
        AuthProvider $provider,
        string $providerId,
        \DateTimeImmutable $createdAt,
    ): self {
        return new self(
            $id,
            $email,
            $name,
            $avatar,
            $provider,
            $providerId,
            $createdAt,
            $createdAt,
        );
    }

    public function updateProfile(
        string $name,
        ?string $avatar,
        \DateTimeImmutable $updatedAt,
    ): void {
        $this->name = $name;
        $this->avatar = $avatar;
        $this->updatedAt = $updatedAt;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function avatar(): ?string
    {
        return $this->avatar;
    }

    public function provider(): AuthProvider
    {
        return $this->provider;
    }

    public function providerId(): string
    {
        return $this->providerId;
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
