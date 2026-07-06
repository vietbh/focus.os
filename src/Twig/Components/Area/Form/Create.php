<?php

namespace App\Twig\Components\Area\Form;

use App\Area\Application\DTO\CreateAreaInput;
use App\Area\Application\UseCase\CreateAreaUseCase;
use App\Form\Area\CreateType;
use App\Identity\Domain\ValueObject\UserId;
use App\Shared\Presentation\Live\DispatchToastTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class Create extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DispatchToastTrait;

    public function __construct(
        private readonly CreateAreaUseCase $createAreaUseCase
    )
    {
    }

    private function getDataModelValue(): ?string
    {
        return 'norender|*';
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(CreateType::class);
    }

    #[LiveAction]
    public function save(): ?RedirectResponse
    {
        $this->submitForm();
        try {
            $user = $this->getUser();

            if (null === $user) {
                throw $this->createAccessDeniedException();
            }
            $data = $this->getForm()->getData();

            $area = $this->createAreaUseCase->execute(
                new CreateAreaInput(
                    userId: UserId::fromString($user->getUserIdentifier()),
                    goalId: $data['goalId']->id(),
                    name: $data['name'],
                ),
            );

            $this->toastSuccess('Area created successfully.');
            $this->redirectToRoute('task_create');
        } catch (\Exception $e) {
            $this->toastError($e->getMessage(), 'Error');
        }
        return null;
    }
}
