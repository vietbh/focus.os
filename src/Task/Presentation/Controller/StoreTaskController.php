<?php

declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Area\Domain\ValueObject\AreaId;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Application\DTO\CreateTaskInput;
use App\Task\Application\UseCase\CreateTaskUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/tasks/create',
)]
final class StoreTaskController extends AbstractController
{
    public function __construct(
        private readonly CreateTaskUseCase $createTaskUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'task_store',
        methods: ['POST'],
    )]
    public function __invoke(
        Request $request,
    ): RedirectResponse {
        $user = $this->getUser();

        $this->createTaskUseCase->execute(
            new CreateTaskInput(
                userId: UserId::fromString($user->getUserIdentifier()),
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
        );

        return $this->redirectToRoute(
            'task_list',
        );
    }
}
