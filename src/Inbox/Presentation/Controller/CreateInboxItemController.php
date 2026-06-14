<?php

declare(strict_types=1);

namespace App\Inbox\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Inbox\Application\DTO\CreateInboxItemInput;
use App\Inbox\Application\UseCase\CreateInboxItemUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/inbox',
)]
final class CreateInboxItemController extends AbstractController
{
    public function __construct(
        private readonly CreateInboxItemUseCase $createInboxItemUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'inbox_store',
        methods: ['POST'],
    )]
    public function __invoke(
        Request $request,
    ): RedirectResponse {
        $user = $this->getUser();

        $this->createInboxItemUseCase->execute(
            new CreateInboxItemInput(
                userId: UserId::fromString($user->getUserIdentifier()),
                content: $request->request->get(
                    'content',
                ),
            ),
        );

        return $this->redirectToRoute(
            'inbox_list',
        );
    }
}
