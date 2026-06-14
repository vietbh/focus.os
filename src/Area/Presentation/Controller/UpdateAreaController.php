<?php

declare(strict_types=1);

namespace App\Area\Presentation\Controller;

use App\Area\Application\DTO\UpdateAreaInput;
use App\Area\Application\UseCase\UpdateAreaUseCase;
use App\Area\Domain\ValueObject\AreaId;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/areas/{areaId}/edit',
)]
final class UpdateAreaController extends AbstractController
{
    public function __construct(
        private readonly UpdateAreaUseCase $updateAreaUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'area_update',
        methods: ['POST'],
    )]
    public function __invoke(
        string $areaId,
        Request $request,
    ): RedirectResponse {
        $this->updateAreaUseCase->execute(
            new UpdateAreaInput(
                areaId: AreaId::fromString(
                    $areaId,
                ),
                goalId: GoalId::fromString($request->request->get('goalId')),
                name: $request->request->get(
                    'name',
                ),
            ),
            UserId::fromString(
                $this->getUser()->getUserIdentifier())
        );

        return $this->redirectToRoute(
            'area_list',
        );
    }
}
