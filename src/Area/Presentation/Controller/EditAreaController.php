<?php

declare(strict_types=1);

namespace App\Area\Presentation\Controller;

use App\Area\Domain\Repository\AreaRepositoryInterface;
use App\Area\Domain\ValueObject\AreaId;
use App\Goal\Application\UseCase\GetGoalListUseCase;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/areas/{areaId}/edit',
)]
final class EditAreaController extends AbstractController
{
    public function __construct(
        private readonly AreaRepositoryInterface $areas,
        private readonly GetGoalListUseCase $getGoalListUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'area_edit',
        methods: ['GET'],
    )]
    public function __invoke(
        string $areaId,
    ): Response {
        $area = $this->areas->findById(
            AreaId::fromString(
                $areaId,
            ),
        );

        if ($area === null) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'area/edit.html.twig',
            [
                'area' => $area,
                'goals' => $this->getGoalListUseCase
                    ->execute(
                        UserId::fromString($this->getUser()->getUserIdentifier()),
                    ),
            ],
        );
    }
}
