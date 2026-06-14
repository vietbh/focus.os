<?php

declare(strict_types=1);

namespace App\Area\Presentation\Controller;

use App\Area\Application\DTO\CreateAreaInput;
use App\Area\Application\UseCase\CreateAreaUseCase;
use App\Goal\Application\UseCase\GetGoalListUseCase;
use App\Goal\Domain\ValueObject\GoalId;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/areas/create',
)]
final class CreateAreaController extends AbstractController
{
    public function __construct(
        private readonly CreateAreaUseCase $createAreaUseCase,
        private readonly GetGoalListUseCase $getGoalListUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'area_create',
        methods: ['GET'],
    )]
    public function form(): Response
    {
        return $this->render(
            'area/create.html.twig',
            [
                'area' => null,
                'goals' => $this->getGoalListUseCase
                    ->execute(
                        UserId::fromString($this->getUser()->getUserIdentifier()),
                    ),
            ],
        );
    }

    #[Route(
        path: '',
        name: 'area_store',
        methods: ['POST'],
    )]
    public function store(
        Request $request,
    ): RedirectResponse {
        $user = $this->getUser();

        $this->createAreaUseCase->execute(
            new CreateAreaInput(
                userId: UserId::fromString($user->getUserIdentifier()),
                goalId: GoalId::fromString($request->request->get('goalId')),
                name: $request->request->get(
                    'name',
                ),
            ),
        );

        return $this->redirectToRoute(
            'area_list',
        );
    }
}
