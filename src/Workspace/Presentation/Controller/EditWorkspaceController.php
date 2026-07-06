<?php

declare(strict_types=1);

namespace App\Workspace\Presentation\Controller;

use App\Area\Domain\Repository\AreaRepositoryInterface;
use App\Area\Domain\ValueObject\AreaId;
use App\Goal\Application\UseCase\GetGoalListUseCase;
use App\Identity\Domain\ValueObject\UserId;
use App\Workspace\Domain\Repository\WorkspaceRepositoryInterface;
use App\Workspace\Domain\ValueObject\WorkspaceId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/workspaces/{workspaceId}/edit',
)]
final class EditWorkspaceController extends AbstractController
{
    public function __construct(
        private readonly WorkspaceRepositoryInterface $workspaceRepository,
    ) {
    }

    #[Route(
        path: '',
        name: 'workspace_edit',
        methods: ['GET'],
    )]
    public function __invoke(
        string $workspaceId,
    ): Response {
        $workspace = $this->workspaceRepository->get(
            WorkspaceId::fromString(
                $workspaceId,
            ),
        );

        if ($workspace === null) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'workspace/edit.html.twig',
            [
                'workspace' => $workspace,

            ],
        );
    }
}
