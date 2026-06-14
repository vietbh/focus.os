<?php

declare(strict_types=1);

namespace App\Inbox\Presentation\Controller;

use App\Area\Domain\ValueObject\AreaId;
use App\Identity\Domain\ValueObject\UserId;
use App\Inbox\Application\DTO\ProcessInboxItemInput;
use App\Inbox\Application\UseCase\ProcessInboxItemUseCase;
use App\Inbox\Domain\ValueObject\InboxItemId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/inbox/{inboxItemId}/process',
)]
final class ProcessInboxToTaskController extends AbstractController
{
    public function __construct(
        private readonly ProcessInboxItemUseCase $processInboxItemUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'inbox_process_task',
        methods: ['POST'],
    )]
    public function __invoke(
        string $inboxItemId,
        Request $request,
    ): RedirectResponse {
        $this->processInboxItemUseCase->execute(
            new ProcessInboxItemInput(
                inboxItemId: InboxItemId::fromString(
                    $inboxItemId,
                ),
                areaId: AreaId::fromString(
                    $request->request->get(
                        'areaId',
                    ),
                ),
                title: $request->request->get(
                    'title',
                ),
                nextAction: $request->request->get(
                    'nextAction',
                ),
                estimatedMinutes: (int) $request->request->get(
                    'estimatedMinutes',
                ),
            ),
            UserId::fromString(
                $this->getUser()->getUserIdentifier())
        );

        return $this->redirectToRoute(
            'task_list',
        );
    }
}
