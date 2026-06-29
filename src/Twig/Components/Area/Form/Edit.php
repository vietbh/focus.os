<?php

namespace App\Twig\Components\Area\Form;

use App\Area\Application\DTO\UpdateAreaInput;
use App\Area\Application\UseCase\DeleteAreaUseCase;
use App\Area\Application\UseCase\UpdateAreaUseCase;
use App\Area\Domain\Entity\Area;
use App\Area\Domain\Repository\AreaRepositoryInterface;
use App\Area\Domain\ValueObject\AreaId;
use App\Form\Area\CreateType;
use App\Form\Area\EditType;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;
use App\Shared\Presentation\Live\DispatchToastTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    use DispatchToastTrait;

    public function __construct(
        private readonly UpdateAreaUseCase $updateAreaUseCase,
        private readonly DeleteAreaUseCase $deleteAreaUseCase,
        private readonly AreaRepositoryInterface $repository
    )
    {
    }

    #[LiveProp]
    public string $areaId;

    private function getDataModelValue(): ?string
    {
        return 'norender|*';
    }

    #[ExposeInTemplate]
    public function area(): Area
    {
        return $this->repository->findById(
            AreaId::fromString($this->areaId)
        );
    }

    protected function instantiateForm(): FormInterface
    {
        $area = $this->area();

        return $this->createForm(EditType::class,
            new UpdateAreaInput(
                $area->id(),
                $area->goalId(),
                $area->name()
            ),
        );
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
            $this->updateAreaUseCase->execute(
                $data,
                UserId::fromString(
                    $this->getUser()->getUserIdentifier())
            );

            $this->toastSuccess('Area created successfully.');
            $this->redirectToRoute('area_list');
        } catch (\Exception $e) {
            $this->toastError($e->getMessage(), 'Error');
        }
        return null;
    }

    #[LiveAction]
    public function deleteArea()
    {
        try {
            $this->deleteAreaUseCase->execute(
                AreaId::fromString($this->areaId),
                UserId::fromString(
                    $this->getUser()->getUserIdentifier())
            );

            return $this->redirectToRoute('area_list');
        }catch (\Exception $e){
            $this->toastError($e->getMessage(), 'Error');
        }

    }
}
