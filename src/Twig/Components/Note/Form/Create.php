<?php

namespace App\Twig\Components\Note\Form;


use App\Form\Note\CreateType;
use App\Goal\Application\UseCase\CreateGoalUseCase;
use App\Identity\Domain\ValueObject\UserId;
use App\Note\Application\DTO\CreateNoteInput;
use App\Note\Application\UseCase\CreateNoteUseCase;
use App\Shared\Presentation\Live\DispatchToastTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
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
        private readonly CreateGoalUseCase    $useCase,
        private readonly CreateNoteUseCase $createNoteUseCase,
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

        if (!$this->getForm()->isValid()) {
            throw new UnprocessableEntityHttpException();
        }
        try {
            $user = $this->getUser();

            if (null === $user) {
                throw $this->createAccessDeniedException();
            }
            $data = $this->getForm()->getData();

            $note = $this->createNoteUseCase->execute(
                new CreateNoteInput(
                    title: $data['title'],
                    content: $data['content'],
                ),
                userId: UserId::fromString($user->getUserIdentifier()),
            );

            $this->toastSuccess('Note created successfully.');
            return $this->redirectToRoute(
                'note_detail',
                [
                    'noteId' => $note->id()->value(),
                ],
            );
        }catch (\Exception $e){
            $this->toastError($e->getMessage(), 'Error');
        }

    }

}
