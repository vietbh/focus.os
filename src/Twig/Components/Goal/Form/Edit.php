<?php

namespace App\Twig\Components\Goal\Form;

use App\Form\Goal\EditType;
use App\Goal\Application\DTO\UpdateGoalInput;
use App\Goal\Application\UseCase\GetGoalDetailUseCase;
use App\Goal\Application\UseCase\UpdateGoalUseCase;
use App\Goal\Domain\Entity\Goal;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class Edit extends AbstractController
{

    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use ComponentToolsTrait;

    public function __construct(
        private readonly FormFactoryInterface $formFactory,
        private readonly UpdateGoalUseCase $useCase,
        private readonly GetGoalDetailUseCase $getGoalDetailUseCase,
    ) {
    }

    #[LiveProp]
    public string $goalId;

    private function getDataModelValue(): ?string
    {
        return 'norender|*';
    }

    protected function instantiateForm(): FormInterface
    {
        $user = $this->getUser();

        if (null === $user) {
            throw $this->createAccessDeniedException();
        }

        $goal = $this->getGoalDetailUseCase->execute(
            UserId::fromString($user->getUserIdentifier()),
            GoalId::fromString(
                $this->goalId,
            ),
        );

        if ($goal === null) {
            throw $this->createNotFoundException();
        }
        return $this->formFactory->create(
            EditType::class,
            [
                'title' => $goal->title(),
                'description' => $goal->description(),
                'targetDate' => $goal->targetDate(),
            ],
        );
    }
    #[LiveAction]
    public function save(): RedirectResponse
    {
        $this->submitForm();

        if (!$this->getForm()->isValid()) {
            throw new UnprocessableEntityHttpException();
        }
        $user = $this->getUser();

        if (null === $user) {
            throw $this->createAccessDeniedException();
        }

        $data = $this->getForm()->getData();

        $this->useCase->execute(
            UserId::fromString(
                $user->getUserIdentifier(),
            ),
            new UpdateGoalInput(
                goalId: GoalId::fromString($this->goalId),
                title: $data['title'],
                description: $data['description'],
                targetDate: $data['targetDate'],
            ),
        );

        $this->addFlash(
            'success',
            'Goal created successfully.',
        );

        return $this->redirectToRoute(
            'goal_detail',
            [
                'goalId' => $this->goalId,
            ],
        );
    }
}
