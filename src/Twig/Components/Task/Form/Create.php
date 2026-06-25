<?php

namespace App\Twig\Components\Task\Form;

use App\Area\Application\UseCase\GetAreaListUseCase;
use App\Area\Domain\ValueObject\AreaId;
use App\Form\Task\CreateType;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Application\DTO\CreateTaskInput;
use App\Task\Application\UseCase\CreateTaskUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class Create extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public function __construct(
        private readonly FormFactoryInterface $formFactory,
        private readonly CreateTaskUseCase $createTaskUseCase,

    ) {
    }

    private function getDataModelValue(): ?string
    {
        return 'norender|*';
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->formFactory->create(
            CreateType::class,
        );
    }

    public function save()
    {
        $this->submitForm();
        try {
            $data = $this->getForm()->getData();
            $user = $this->getUser();

            $this->createTaskUseCase->execute(
                new CreateTaskInput(
                    userId: UserId::fromString($user->getUserIdentifier()),
                    areaId: AreaId::fromString(
                        $data['areaId']
                    ),
                    title: $data['title'],
                    description: $data['description'],
                    nextAction: $data['nextAction'],
                    estimatedMinutes: (int) $data['estimatedMinutes'],
                ),
            );
        }catch (\Exception $e){

        }
    }

}
