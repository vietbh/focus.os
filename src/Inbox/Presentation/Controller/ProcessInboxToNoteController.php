<?php

declare(strict_types=1);

namespace App\Inbox\Presentation\Controller;

use App\Inbox\Application\DTO\ProcessInboxToNoteInput;
use App\Inbox\Application\UseCase\ProcessInboxToNoteUseCase;
use App\Inbox\Domain\ValueObject\InboxItemId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/inbox/{inboxItemId}/note',
)]
final class ProcessInboxToNoteController extends AbstractController
{
    public function __construct(
        private readonly ProcessInboxToNoteUseCase $useCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'inbox_process_note',
        methods: ['POST'],
    )]
    public function __invoke(
        string $inboxItemId,
        Request $request,
    ): RedirectResponse {
        $this->useCase->execute(
            new ProcessInboxToNoteInput(
                inboxItemId: InboxItemId::fromString(
                    $inboxItemId,
                ),
                title: $request->request->get(
                    'title',
                ),
            ),
        );

        return $this->redirectToRoute(
            'note_list',
        );
    }
}
