<?php

namespace App\Twig\Components\Note;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Application\UseCase\DeleteNoteUseCase;
use App\Note\Application\UseCase\GetNoteDetailUseCase;
use App\Note\Domain\ValueObject\NoteId;
use App\Shared\Presentation\Live\DispatchToastTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
final class Detail extends AbstractController
{
    use DefaultActionTrait;
    use DispatchToastTrait;


    public function __construct(private readonly GetNoteDetailUseCase $getNoteDetailUseCase, private readonly DeleteNoteUseCase $deleteNoteUseCase)
    {
    }

    #[LiveProp]
    public string $noteId;

    #[ExposeInTemplate]
    public function note(): ?\App\Note\Domain\Entity\Note
    {
        $user = $this->getUser();

        return $this->getNoteDetailUseCase->execute(
            UserId::fromString($user->getUserIdentifier()),
            NoteId::fromString(
                $this->noteId,
            ),
        );
    }

    #[LiveAction]
    public function deleteNote()
    {
        $user = $this->getUser();

        try {

            $this->deleteNoteUseCase->execute(
                UserId::fromString($user->getUserIdentifier()),
                NoteId::fromString(
                    $this->noteId,
                ),
            );
            $this->toastSuccess('Note has been deleted.');
            return $this->redirectToRoute('note_list');
        }catch (\Exception $exception){
            $this->toastError($exception->getMessage(), 'Error');
        }
    }
}
