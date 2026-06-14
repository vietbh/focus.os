<?php

declare(strict_types=1);

namespace App\Inbox\Presentation\Controller;

use App\Inbox\Application\UseCase\GetInboxListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/inbox',
)]
final class InboxController extends AbstractController
{
    public function __construct(
        private readonly GetInboxListUseCase $getInboxListUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'inbox_list',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'inbox/list.html.twig',
            [
                'items' => $this->getInboxListUseCase->execute(
                    $user->getUserIdentifier(),
                ),
            ],
        );
    }
}
