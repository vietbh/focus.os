<?php

declare(strict_types=1);

namespace App\Review\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Application\UseCase\GetMonthlyReviewListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/reviews/monthly',
)]
final class MonthlyReviewController extends AbstractController
{
    public function __construct(
        private readonly GetMonthlyReviewListUseCase $getMonthlyReviewListUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'monthly_review_list',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'review/monthly/list.html.twig',
            [
                'reviews' => $this->getMonthlyReviewListUseCase
                    ->execute(
                        UserId::fromString($user->getUserIdentifier()),
                    ),
            ],
        );
    }
}
