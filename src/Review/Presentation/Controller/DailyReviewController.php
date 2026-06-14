<?php

declare(strict_types=1);

namespace App\Review\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Application\UseCase\GetDailyReviewListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/reviews/daily',
)]
final class DailyReviewController extends AbstractController
{
    public function __construct(
        private readonly GetDailyReviewListUseCase $getDailyReviewListUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'daily_review_list',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'review/daily/list.html.twig',
            [
                'reviews' => $this->getDailyReviewListUseCase->execute(
                    UserId::fromString($user->getUserIdentifier()),
                ),
            ],
        );
    }
}
