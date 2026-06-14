<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Area\Domain\ValueObject\AreaId;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Application\DTO\UpdateTaskInput;
use App\Task\Application\UseCase\UpdateTaskUseCase;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/tasks/{taskId}/edit',
)]
final class UpdateTaskController extends AbstractController
{
    public function __construct(
        private readonly UpdateTaskUseCase $updateTaskUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'task_update',
        methods: ['POST'],
    )]
    public function __invoke(
        string $taskId,
        Request $request,
    ): RedirectResponse {
        $this->updateTaskUseCase->execute(
            new UpdateTaskInput(
                taskId: TaskId::fromString(
                    $taskId,
                ),
                areaId: AreaId::fromString(
                    $request->request->get(
                        'areaId',
                    ),
                ),
                title: $request->request->get(
                    'title',
                ),
                description: $request->request->get(
                    'description',
                ),
                nextAction: $request->request->get(
                    'nextAction',
                ),
                estimatedMinutes: (int) $request->request->get(
                    'estimatedMinutes',
                ),
            ),
            UserId::fromString(
                $this->getUser()->getUserIdentifier())
        );

        return $this->redirectToRoute(
            'task_detail',
            [
                'taskId' => $taskId,
            ],
        );
    }
}
