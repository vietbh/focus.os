<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Identity\Domain\Entity\User;
use App\Identity\Domain\ValueObject\UserId;
use App\Shared\Presentation\Turbo\TurboResponder;
use App\Task\Application\DTO\ResumeTaskInput;
use App\Task\Application\UseCase\ResumeTaskUseCase;
use App\Task\Domain\Repository\TaskRepositoryInterface;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/tasks/{taskId}/resume',
)]
final class ResumeTaskController extends AbstractController
{
    public function __construct(
        private readonly ResumeTaskUseCase $resumeTaskUseCase,
        private readonly TaskRepositoryInterface $taskRepository,
    ) {
    }

    #[Route(
        path: '',
        name: 'task_resume',
        methods: ['POST'],
    )]
    public function __invoke(
        string $taskId,
        Request $request,
    ): Response {

        $user = $this->getUser();

        $this->resumeTaskUseCase->execute(
            new ResumeTaskInput(
                TaskId::fromString(
                    $taskId,
                ),
                UserId::fromString($user->getUserIdentifier()),
            )
        );

        $task = $this
            ->taskRepository
            ->findById(TaskId::fromString($taskId));

        if (
            TurboResponder::isTurbo(
                $request,
            )
        ) {
            return new Response(
                $this->renderView(
                    'task/_actions.stream.html.twig',
                    [
                        'task' => $task,
                    ],
                ),
                Response::HTTP_OK,
                [
                    'Content-Type'
                    => 'text/vnd.turbo-stream.html',
                ],
            );
        }

        $this->addFlash(
            'success',
            'Task started.',
        );

        return $this->redirectToRoute(
            'task_detail',
            [
                'taskId' => $taskId,
            ],
        );
    }
}
