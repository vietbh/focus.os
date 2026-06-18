<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Shared\Presentation\Turbo\TurboResponder;
use App\Task\Application\DTO\StartTaskInput;
use App\Task\Application\UseCase\StartTaskUseCase;
use App\Task\Domain\Repository\TaskRepositoryInterface;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StartTaskController extends AbstractController
{
    public function __construct(
        private readonly StartTaskUseCase $useCase,
        private readonly TaskRepositoryInterface $taskRepository,
    ) {
    }

    #[Route(
        '/tasks/{taskId}/start',
        name: 'task_start',
        methods: ['POST'],
    )]
    public function __invoke(
        string $taskId,
        Request $request,
    ): Response {
        $this->useCase->execute(
            new StartTaskInput(
                taskId: TaskId::fromString($taskId),
                userId: UserId::fromString($this->getUser()->getUserIdentifier())
            ),
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
