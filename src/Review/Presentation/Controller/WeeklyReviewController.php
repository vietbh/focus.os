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
    name: 'weekly_review_list',
)]
final class WeeklyReviewController extends AbstractController
{
    public function __construct(
        private readonly GetWeeklyReviewListUseCase $useCase,
    ) {
    }

    public function __invoke(): Response
    {
        $userId = UserId::fromString(
            $this->getUser()
                ->getUserIdentifier(),
        );

        $reviews = $this->useCase
            ->execute(
                $userId,
            );

        return $this->render(
            'review/weekly/list.html.twig',
            [
                'reviews' => $reviews,
                'reviewType' => 'weekly',
            ],
        );
    }
}
