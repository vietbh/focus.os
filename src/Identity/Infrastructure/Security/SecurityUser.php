<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\Security;

use App\Identity\Domain\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class SecurityUser implements UserInterface
{
    public function __construct(
        private User $user,
    ) {
    }

    public function getUserIdentifier(): string
    {
        return $this->user
            ->id()
            ->value();
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    public function eraseCredentials(): void
    {
    }

    public function getName(): string
    {
        return $this->user->name();
    }

    public function getAvatar(): string
    {
        return $this->user->avatar();
    }

    public function getEmail(): string
    {
        return $this->user->email();
    }

    public function user(): User
    {
        return $this->user;
    }
}
