<?php

declare(strict_types=1);

namespace App\Inbox\Presentation\Controller;

use App\Area\Application\UseCase\GetAreaListUseCase;
use App\Inbox\Domain\Repository\InboxItemRepositoryInterface;
use App\Inbox\Domain\ValueObject\InboxItemId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/inbox/{inboxItemId}/process',
)]
final class ProcessInboxItemController extends AbstractController
{
    public function __construct(
        private readonly InboxItemRepositoryInterface $items,
        private readonly GetAreaListUseCase $getAreaListUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'inbox_process',
        methods: ['GET'],
    )]
    public function __invoke(
        string $inboxItemId,
    ): Response {
        $user = $this->getUser();

        $item = $this->items->findById(
            InboxItemId::fromString(
                $inboxItemId,
            ),
        );

        if ($item === null) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'inbox/process.html.twig',
            [
                'item' => $item,
                'areas' => $this->getAreaListUseCase->execute(
                    $user->getUserIdentifier(),
                ),
            ],
        );
    }
}
