<?php

namespace App\Twig\Components\Note\Form;

use App\Form\Note\EditType;
use App\Identity\Domain\ValueObject\UserId;
use App\Note\Application\DTO\UpdateNoteInput;
use App\Note\Application\UseCase\GetNoteDetailUseCase;
use App\Note\Application\UseCase\UpdateNoteUseCase;
use App\Note\Domain\ValueObject\NoteId;
use App\Shared\Presentation\Live\DispatchToastTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
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

    public function __construct(

        private readonly GetNoteDetailUseCase $getNoteDetailUseCase, private readonly UpdateNoteUseCase $updateNoteUseCase)
    {
    }

    #[LiveProp]
    public string $noteId;

    public function note(): ?\App\Note\Domain\Entity\Note
    {

        return $this->getNoteDetailUseCase->execute(
            UserId::fromString($this->getUser()->getUserIdentifier()),
            NoteId::fromString($this->noteId),
        );
    }

    private function getDataModelValue(): ?string
    {
        return 'norender|*';
    }

    protected function instantiateForm(): FormInterface
    {
        $note = $this->note();

        return $this->createForm(
            EditType::class,
            new UpdateNoteInput(
                noteId: $note->id(),
                title: $note->title(),
                content: $note->content(),
            ),
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

            $this->updateNoteUseCase->execute(
                UserId::fromString($user->getUserIdentifier()),
                $data
            );

            $this->toastSuccess('Note created successfully.');
            return $this->redirectToRoute(
                'note_detail',
                [
                    'noteId' => $this->noteId,
                ],
            );
        }catch (\Exception $e){
            $this->toastError($e->getMessage(), 'Error');
        }

    }


}
