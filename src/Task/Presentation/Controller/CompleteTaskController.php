<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Task\Application\UseCase\CompleteTaskUseCase;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/tasks/{taskId}/complete',
)]
final class CompleteTaskController extends AbstractController
{
    public function __construct(
        private readonly CompleteTaskUseCase $completeTaskUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'task_complete',
        methods: ['POST'],
    )]
    public function __invoke(
        string $taskId,
    ): RedirectResponse {
        $this->completeTaskUseCase->execute(
            TaskId::fromString(
                $taskId,
            ),
            UserId::fromString(
                $this->getUser()->getUserIdentifier())
        );

        return $this->redirectToRoute(
            'task_list',
        );
    }
}
