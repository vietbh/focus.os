<?php

declare(strict_types=1);

namespace App\Note\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Application\DTO\CreateNoteInput;
use App\Note\Application\UseCase\CreateNoteUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/notes/create',
)]
final class CreateNoteController extends AbstractController
{
    public function __construct(
        private readonly CreateNoteUseCase $createNoteUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'note_create',
        methods: ['GET'],
    )]
    public function form(): Response
    {
        return $this->render(
            'note/edit.html.twig',
            [
                'note' => null,
            ],
        );
    }

    #[Route(
        path: '',
        name: 'note_store',
        methods: ['POST'],
    )]
    public function store(
        Request $request,
    ): RedirectResponse {
        $user = $this->getUser();

        $this->createNoteUseCase->execute(
            new CreateNoteInput(
                userId: UserId::fromString($user->getUserIdentifier()),
                title: $request->request->get(
                    'title',
                ),
                content: $request->request->get(
                    'content',
                ),
            ),
        );

        return $this->redirectToRoute(
            'note_list',
        );
    }
}
