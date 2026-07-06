<?php

namespace App\Twig\Components\Workspace;

use App\Identity\Application\Service\CurrentWorkspaceProviderInterface;
use App\Workspace\Application\Command\SwitchWorkspaceCommand;
use App\Workspace\Application\Query\WorkspaceQueryInterface;
use App\Workspace\Application\UseCase\SwitchWorkspaceUseCase;
use App\Workspace\Domain\Entity\Workspace;
use App\Workspace\Domain\ValueObject\WorkspaceId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
final class SwitchWorkspace extends AbstractController
{
    use DefaultActionTrait;

    public function __construct(
        private readonly WorkspaceQueryInterface $workspaceQuery,
        private readonly CurrentWorkspaceProviderInterface $currentWorkspaceProvider,
        private readonly SwitchWorkspaceUseCase $switchWorkspaceUseCase,
    ) {
    }

    #[LiveProp(writable: true)]
    public bool $expanded = false;

    #[ExposeInTemplate]
    public function workspaces(): array
    {
        return $this->workspaceQuery->list();
    }


    #[ExposeInTemplate]
    public function currentWorkspace(): ?Workspace
    {
        return $this->currentWorkspaceProvider
            ->current();
    }

    #[LiveAction]
    public function switch(
        #[LiveArg]
        string $workspaceId,
    )
    {
        $this->switchWorkspaceUseCase->execute(
            new SwitchWorkspaceCommand(
                WorkspaceId::fromString($workspaceId),
            ),
        );
        return $this->redirectToRoute('dashboard');
    }

    #[LiveAction]
    public function toggle(): void
    {
        $this->expanded = !$this->expanded;
    }
}
