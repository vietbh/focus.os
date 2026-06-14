<?php

declare(strict_types=1);

namespace App\Area\Presentation\Controller;

use App\Area\Application\UseCase\DeleteAreaUseCase;
use App\Area\Domain\ValueObject\AreaId;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/areas/{areaId}/delete',
)]
final class DeleteAreaController extends AbstractController
{
    public function __construct(
        private readonly DeleteAreaUseCase $deleteAreaUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'area_delete',
        methods: ['POST'],
    )]
    public function __invoke(
        string $areaId,
    ): RedirectResponse {

        $this->deleteAreaUseCase->execute(
            AreaId::fromString(
                $areaId,
            ),
            UserId::fromString(
                $this->getUser()->getUserIdentifier())
        );

        return $this->redirectToRoute(
            'area_list',
        );
    }
}
