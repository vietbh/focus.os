<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Identity\Domain\Entity\User;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Application\UseCase\ResumeTaskUseCase;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/tasks/{taskId}/resume',
)]
final class ResumeTaskController extends AbstractController
{
    public function __construct(
        private readonly ResumeTaskUseCase $resumeTaskUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'task_resume',
        methods: ['POST'],
    )]
    public function __invoke(
        string $taskId,
    ): RedirectResponse {

        $user = $this->getUser();

        $this->resumeTaskUseCase->execute(
            UserId::fromString($user->getUserIdentifier()),
            TaskId::fromString(
                $taskId,
            ),
        );

        return $this->redirectToRoute(
            'task_list',
        );
    }
}
