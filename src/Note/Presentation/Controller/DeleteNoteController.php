<?php

declare(strict_types=1);

namespace App\Note\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Application\UseCase\DeleteNoteUseCase;
use App\Note\Domain\ValueObject\NoteId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/notes/{noteId}/delete',
)]
final class DeleteNoteController extends AbstractController
{
    public function __construct(
        private readonly DeleteNoteUseCase $deleteNoteUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'note_delete',
        methods: ['POST'],
    )]
    public function __invoke(
        string $noteId,
    ): RedirectResponse {
        $user = $this->getUser();

        $this->deleteNoteUseCase->execute(
            UserId::fromString($user->getUserIdentifier()),
            NoteId::fromString(
                $noteId,
            ),
        );

        return $this->redirectToRoute(
            'note_list',
        );
    }
}
