<?php

declare(strict_types=1);

namespace App\Review\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Application\UseCase\GetWeeklyReviewListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/reviews/weekly',
)]
final class WeeklyReviewController extends AbstractController
{
    public function __construct(
        private readonly GetWeeklyReviewListUseCase $getWeeklyReviewListUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'weekly_review_list',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'review/weekly/list.html.twig',
            [
                'reviews' => $this->getWeeklyReviewListUseCase
                    ->execute(
                        UserId::fromString($user->getUserIdentifier()),
                    ),
            ],
        );
    }
}
