<?php

declare(strict_types=1);

namespace App\Dashboard\Presentation\Controller;

use App\Dashboard\Application\UseCase\GetDashboardUseCase;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route(
    path: '/dashboard',
    name: 'dashboard',
    methods: ['GET'],
)]
final class DashboardController extends AbstractController
{
    public function __construct(
        private readonly GetDashboardUseCase $getDashboardUseCase,
    ) {
    }


    public function __invoke(): Response
    {
//        $keys = \Minishlink\WebPush\VAPID::createVapidKeys();
//
//        return new Response(json_encode($keys));
        $user = $this->getUser();

        return $this->render(
            'dashboard/index.html.twig',
            [
                'snapshot' => $this->getDashboardUseCase
                    ->execute(
                        UserId::fromString($user->getUserIdentifier()),
                    ),
            ],
        );
    }
}
