<?php

namespace App\Twig\Components\Workspace\Form;

use App\Form\Workspace\WorkspaceFormType;
use App\Workspace\Application\Command\UpdateWorkspaceCommand;
use App\Workspace\Application\DTO\WorkspaceFormDto;
use App\Workspace\Application\UseCase\UpdateWorkspaceUseCase;
use App\Workspace\Domain\Entity\Workspace;
use App\Workspace\Domain\Repository\WorkspaceRepositoryInterface;
use App\Workspace\Domain\ValueObject\WorkspaceId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
final class Edit extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public string $workspaceId;

    public function __construct(
        private readonly UpdateWorkspaceUseCase       $updateWorkspaceUseCase,
        private readonly WorkspaceRepositoryInterface $workspaceRepository,

    ) {
    }

    private function getDataModelValue(): ?string
    {
        return 'norender|*';
    }

    #[ExposeInTemplate]
    public function workspace(): ?Workspace
    {
        return $this->workspaceRepository->get(
            WorkspaceId::fromString($this->workspaceId),
        );
    }

    protected function instantiateForm():FormInterface
    {
        $workspace = $this->workspace();
        $workspaceDto = new WorkspaceFormDto();
        $workspaceDto->name = $workspace->name();
        $workspaceDto->description = $workspace->description();
        $workspaceDto->color = $workspace->color();

        return $this->createForm(
            WorkspaceFormType::class,
            $workspaceDto
        );
    }

    #[LiveAction]
    public function save(): void
    {
        $this->submitForm();

        /** @var WorkspaceFormDto $data */
        $data = $this->getForm()->getData();

        $this->updateWorkspaceUseCase->execute(
            new UpdateWorkspaceCommand(
                workspaceId: $this->workspace()->id(),
                name: $data->name,
                description: $data->description,
                icon: $data->icon,
                color: $data->color,
            ),
        );

        $this->resetForm();
    }
}
