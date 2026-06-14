<?php

declare(strict_types=1);

namespace App\Note\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Application\UseCase\GetNoteListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/notes',
)]
final class NoteController extends AbstractController
{
    public function __construct(
        private readonly GetNoteListUseCase $getNoteListUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'note_list',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'note/list.html.twig',
            [
                'notes' => $this->getNoteListUseCase->execute(
                    UserId::fromString($user->getUserIdentifier()),
                ),
            ],
        );
    }
}
