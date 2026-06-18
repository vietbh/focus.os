<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Shared\Presentation\Turbo\TurboResponder;
use App\Task\Application\DTO\CompleteTaskInput;
use App\Task\Application\UseCase\CompleteTaskUseCase;
use App\Task\Domain\Repository\TaskRepositoryInterface;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/tasks/{taskId}/complete',
)]
final class CompleteTaskController extends AbstractController
{
    public function __construct(
        private readonly CompleteTaskUseCase $completeTaskUseCase,
        private readonly TaskRepositoryInterface $taskRepository,
    ) {
    }

    #[Route(
        path: '',
        name: 'task_complete',
        methods: ['POST'],
    )]
    public function __invoke(
        string $taskId,
        Request $request,
    ): Response {
        $this->completeTaskUseCase->execute(
            new CompleteTaskInput(
                TaskId::fromString(
                    $taskId,
                ),
                UserId::fromString(
                    $this->getUser()->getUserIdentifier()),
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
