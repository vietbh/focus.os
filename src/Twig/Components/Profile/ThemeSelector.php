<?php

declare(strict_types=1);

namespace App\Twig\Components\Profile;

use App\Identity\Domain\Enum\Theme;
use App\Identity\Domain\Repository\UserPreferenceRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
final class ThemeSelector extends AbstractController
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    public function __construct(
        private readonly UserPreferenceRepositoryInterface $preferences,
    ) {
    }

    #[ExposeInTemplate]
    public function currentTheme(): Theme
    {
        $userId = UserId::fromString($this->getUser()->getUserIdentifier());

        return $this->preferences
            ->getByUser($userId)
            ->theme();
    }

    #[LiveAction]
    public function change(
        #[LiveArg] string $theme,
    ): void {
        $userId = UserId::fromString($this->getUser()->getUserIdentifier());

        $preference =
            $this->preferences
                ->getByUser($userId);

        $preference->changeTheme(
            Theme::from($theme),
        );

        $this->preferences
            ->save($preference);
        $this->dispatchBrowserEvent(
            'theme:changed',
            [
                'theme' => $theme,
            ],
        );
    }

}
