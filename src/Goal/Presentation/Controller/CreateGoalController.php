<?php

declare(strict_types=1);

namespace App\Goal\Presentation\Controller;

use App\Goal\Application\DTO\CreateGoalInput;
use App\Goal\Application\UseCase\CreateGoalUseCase;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/goals/create',
)]
final class CreateGoalController extends AbstractController
{
    public function __construct(
        private readonly CreateGoalUseCase $createGoalUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'goal_create',
        methods: ['GET'],
    )]
    public function form(): Response
    {
        return $this->render(
            'goal/edit.html.twig',
            [
                'goal' => null,
            ],
        );
    }

    /**
     * @throws \Exception
     */
    #[Route(
        path: '',
        name: 'goal_store',
        methods: ['POST'],
    )]
    public function store(
        Request $request,
    ): RedirectResponse {
        $user = $this->getUser();

        $targetDate = $request->request->get(
            'targetDate',
        );

        $this->createGoalUseCase->execute(
            new CreateGoalInput(
                userId: UserId::fromString($user->getUserIdentifier()),
                title: $request->request->get(
                    'title',
                ),
                description: $request->request->get(
                    'description',
                ),
                targetDate: $targetDate
                    ? new \DateTimeImmutable(
                        $targetDate,
                    )
                    : null,
            ),
        );

        return $this->redirectToRoute(
            'goal_list',
        );
    }
}
