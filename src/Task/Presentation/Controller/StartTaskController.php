<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Identity\Domain\Entity\User;
use App\Identity\Domain\ValueObject\UserId;
use App\Shared\Presentation\Turbo\TurboResponder;
use App\Task\Application\UseCase\StartTaskUseCase;
use App\Task\Domain\Repository\TaskRepositoryInterface;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/tasks/{taskId}/start',
)]
final class StartTaskController extends AbstractController
{
    public function __construct(
        private readonly StartTaskUseCase $startTaskUseCase, private readonly TaskRepositoryInterface $taskRepository,
    ) {
    }

    #[Route(
        path: '',
        name: 'task_start',
        methods: ['POST'],
    )]
    public function __invoke(
        TaskId $taskId,
        Request $request,
    ): Response {
        $this->startTaskUseCase->execute(
            UserId::fromString($this->getUser()->getUserIdentifier()),
            $taskId,
        );

        $task = $this->taskRepository->findById($taskId);

        if (
            TurboResponder::isTurbo(
                $request,
            )
        ) {
            return $this->render(
                'task/_actions.stream.html.twig',
                [
                    'task' => $task,
                ],
            );
        }

        return $this->redirectToRoute(
            'task_detail',
            [
                'taskId' => $task->id(),
            ],
        );
    }
}
