<?php

namespace App\Twig\Components\Workspace\Form;

use App\Form\Workspace\WorkspaceFormType;
use App\Workspace\Application\Command\CreateWorkspaceCommand;
use App\Workspace\Application\DTO\WorkspaceFormDto;
use App\Workspace\Application\UseCase\CreateWorkspaceUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class Create extends AbstractController
{
    use DefaultActionTrait;
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public function __construct(
        private readonly CreateWorkspaceUseCase $createWorkspaceUseCase,
    ) {
    }

    private function getDataModelValue(): ?string
    {
        return 'norender|*';
    }

    protected function instantiateForm():FormInterface
    {
        return $this->createForm(
            WorkspaceFormType::class,
        );
    }

    #[LiveAction]
    public function save(): void
    {
        $this->submitForm();

        /** @var WorkspaceFormDto $data */
        $data = $this->getForm()->getData();

        $this->createWorkspaceUseCase->execute(
            new CreateWorkspaceCommand(
                name: $data->name,
                description: $data->description,
                icon: $data->icon,
                color: $data->color,
            ),
        );

        $this->resetForm();
    }
}
