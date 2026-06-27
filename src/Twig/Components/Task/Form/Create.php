<?php

namespace App\Twig\Components\Task\Form;

use App\Area\Application\UseCase\GetAreaListUseCase;
use App\Area\Domain\ValueObject\AreaId;
use App\Form\Task\CreateType;
use App\Identity\Domain\ValueObject\UserId;
use App\Shared\Presentation\Live\DispatchToastTrait;
use App\Task\Application\DTO\CreateTaskInput;
use App\Task\Application\UseCase\CreateTaskUseCase;
use App\Task\Domain\ValueObject\NextAction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class Create extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DispatchToastTrait;

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
        return $this->createForm(
            CreateType::class,
        );
    }

    #[LiveAction]
    public function save()
    {
        $this->submitForm();

        try {
            $data = $this->getForm()->getData();
            $user = $this->getUser();

            $task = $this->createTaskUseCase->execute(
                new CreateTaskInput(
                    areaId: $data['areaId'],
                    title: $data['title'],
                    description: $data['description'],
                    nextAction: NextAction::fromString($data['nextAction']),
                    estimatedMinutes: (int) $data['estimatedMinutes'],
                ),
                userId: UserId::fromString($user->getUserIdentifier()),
            );
            $this->toastSuccess( 'Create successfully!');

            return $this->redirectToRoute('task_detail',[
                'taskId' => $task->id()->value()
            ]);

        }catch (\Exception $e){
            $this->toastError( $e->getMessage(), 'Error');
        }
    }

}
