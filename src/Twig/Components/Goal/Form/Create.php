<?php

namespace App\Twig\Components\Goal\Form;

use App\Form\Goal\CreateType;
use App\Goal\Application\DTO\CreateGoalInput;
use App\Goal\Application\UseCase\CreateGoalUseCase;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
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
    use ComponentToolsTrait;

    public function __construct(
        private readonly FormFactoryInterface $formFactory,
        private readonly CreateGoalUseCase $useCase,
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
        $goal = $this->useCase->execute(
            new CreateGoalInput(
                userId: UserId::fromString(
                    $user->getUserIdentifier(),
                ),
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
                'goalId' => $goal->id()->value(),
            ],
        );
    }
}
