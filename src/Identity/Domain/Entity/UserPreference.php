<?php

declare(strict_types=1);

namespace App\Identity\Domain\Entity;

use App\Identity\Domain\Enum\LandingPage;
use App\Identity\Domain\Enum\Theme;
use App\SharedKernel\Domain\ValueObject\Uuid;

class UserPreference
{
    private string $id;

    private User $user;

    private Theme $theme;

    private LandingPage $landingPage;

    private bool $compactMode;

    private array $featureFlags = [];

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        User $user,
    ) {
        $this->id = $id;
        $this->user = $user;

        $this->theme = Theme::SYSTEM;

        $this->landingPage =
            LandingPage::TODAY;

        $this->compactMode = false;

        $this->createdAt =
            new \DateTimeImmutable();

        $this->updatedAt =
            new \DateTimeImmutable();
    }

    public static function create(
        User $user,
    ): self {
        return new self(
            Uuid::generate()->value(),
            $user,
        );
    }

    public function theme(): Theme
    {
        return $this->theme;
    }

    public function landingPage(): LandingPage
    {
        return $this->landingPage;
    }

    public function compactMode(): bool
    {
        return $this->compactMode;
    }

    public function changeTheme(
        Theme $theme,
    ): void {
        $this->theme = $theme;

        $this->touch();
    }

    public function changeLandingPage(
        LandingPage $landingPage,
    ): void {
        $this->landingPage =
            $landingPage;

        $this->touch();
    }

    public function enableCompactMode(): void
    {
        $this->compactMode = true;

        $this->touch();
    }

    public function disableCompactMode(): void
    {
        $this->compactMode = false;

        $this->touch();
    }

    private function touch(): void
    {
        $this->updatedAt =
            new \DateTimeImmutable();
    }
}
