<?php

namespace App\Twig\Components\Task\Form;

use App\Area\Domain\Repository\AreaRepositoryInterface;
use App\Form\Task\EditType;
use App\Identity\Domain\ValueObject\UserId;
use App\Shared\Presentation\Live\DispatchToastTrait;
use App\Task\Application\DTO\UpdateTaskInput;
use App\Task\Application\UseCase\GetTaskDetailUseCase;
use App\Task\Application\UseCase\UpdateTaskUseCase;
use App\Task\Domain\ValueObject\NextAction;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class Edit extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DispatchToastTrait;

    #[LiveProp]
    public string $taskId;


    public function __construct(
        private readonly FormFactoryInterface $formFactory,
        private readonly UpdateTaskUseCase    $updateTaskUseCase,
        private readonly GetTaskDetailUseCase $getTaskDetailUseCase,

        private readonly AreaRepositoryInterface $areas,
    ) {
    }

    private function getDataModelValue(): ?string
    {
        return 'norender|*';
    }

    protected function instantiateForm(): FormInterface
    {
        $task = $this->getTaskDetailUseCase->execute(
            TaskId::fromString($this->taskId),
            UserId::fromString($this->getUser()->getUserIdentifier())
        );

        if ($task === null) {
            throw $this->createNotFoundException();
        }

        return $this->formFactory->create(
            EditType::class,
            [
                'areaId' => $task->areaId()->value(),
                'title' => $task->title(),
                'description' => $task->description(),
                'nextAction' => $task->nextAction()->value(),
                'estimatedMinutes' => $task->estimatedMinutes()
            ]
        );
    }

    #[LiveAction]
    public function save(): void
    {
        $this->submitForm();
        try {
            $data = $this->getForm()->getData();
            $user = $this->getUser();

            $this->updateTaskUseCase->execute(
                new UpdateTaskInput(
                    taskId: TaskId::fromString($this->taskId),
                    areaId: $data['areaId']->id(),
                    title: $data['title'],
                    description: $data['description'],
                    nextAction: NextAction::fromString($data['nextAction']),
                    estimatedMinutes: (int) $data['estimatedMinutes'],
                ),
                UserId::fromString($user->getUserIdentifier())
            );
            $this->toastSuccess( 'Updated successfully!');
        }catch (\Exception $e){
            $this->toastError( $e->getMessage(), 'Error');
        }
    }

}
