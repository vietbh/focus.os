<?php

declare(strict_types=1);

namespace App\Identity\Application\Service;

use App\Identity\Domain\Entity\User;
use App\Identity\Domain\Enum\Theme;
use App\Identity\Domain\Repository\UserPreferenceRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class ThemeResolver
{
    public function __construct(
        private Security $security,
        private UserPreferenceRepositoryInterface $preferences,
    ) {
    }

    public function resolve(): Theme
    {
        $userId = UserId::fromString($this->security->getUser()->getUserIdentifier());

        return $this->preferences
            ->getByUser($userId)
            ->theme();
    }

    public function isDark(): bool
    {
        return $this->resolve() === Theme::DARK;
    }

    public function isLight(): bool
    {
        return $this->resolve() === Theme::LIGHT;
    }

    public function isSystem(): bool
    {
        return $this->resolve() === Theme::SYSTEM;
    }
}
