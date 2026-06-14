<?php

declare(strict_types=1);

namespace App\Note\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Application\UseCase\GetNoteDetailUseCase;
use App\Note\Domain\ValueObject\NoteId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/notes/{noteId}/edit',
)]
final class EditNoteController extends AbstractController
{
    public function __construct(
        private readonly GetNoteDetailUseCase $getNoteDetailUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'note_edit',
        methods: ['GET'],
    )]
    public function __invoke(
        string $noteId,
    ): Response {
        $user = $this->getUser();

        $note = $this->getNoteDetailUseCase->execute(
            UserId::fromString($user->getUserIdentifier()),
            NoteId::fromString(
                $noteId,
            ),
        );

        if ($note === null) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'note/edit.html.twig',
            [
                'note' => $note,
            ],
        );
    }
}
