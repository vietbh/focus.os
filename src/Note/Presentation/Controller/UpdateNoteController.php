<?php

declare(strict_types=1);

namespace App\Note\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Application\DTO\UpdateNoteInput;
use App\Note\Application\UseCase\UpdateNoteUseCase;
use App\Note\Domain\ValueObject\NoteId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/notes/{noteId}/edit',
)]
final class UpdateNoteController extends AbstractController
{
    public function __construct(
        private readonly UpdateNoteUseCase $updateNoteUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'note_update',
        methods: ['POST'],
    )]
    public function __invoke(
        string $noteId,
        Request $request,
    ): RedirectResponse {
        $user = $this->getUser();

        $this->updateNoteUseCase->execute(
            UserId::fromString($user->getUserIdentifier()),
            new UpdateNoteInput(
                noteId: NoteId::fromString(
                    $noteId,
                ),
                title: $request->request->get(
                    'title',
                ),
                content: $request->request->get(
                    'content',
                ),
            ),
        );

        return $this->redirectToRoute(
            'note_detail',
            [
                'noteId' => $noteId,
            ],
        );
    }
}
