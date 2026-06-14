<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\Security;

use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final readonly class SecurityUserProvider
    implements UserProviderInterface
{
    public function __construct(
        private UserRepositoryInterface $users,
    ) {}

    public function loadUserByIdentifier(
        string $identifier,
    ): UserInterface {
        $user = $this->users->findById(
            UserId::fromString($identifier),
        );

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return new SecurityUser(
            $user
        );
    }

    public function refreshUser(
        UserInterface $user,
    ): UserInterface {
        return $this->loadUserByIdentifier(
            $user->getUserIdentifier(),
        );
    }

    public function supportsClass(
        string $class,
    ): bool {
        return $class === SecurityUser::class;
    }
}
