<?php

declare(strict_types=1);

namespace App\Review\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Review\Application\DTO\CreateWeeklyReviewInput;
use App\Review\Application\UseCase\CreateWeeklyReviewUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/reviews/weekly/create',
)]
final class CreateWeeklyReviewController extends AbstractController
{
    public function __construct(
        private readonly CreateWeeklyReviewUseCase $createWeeklyReviewUseCase,
    ) {
    }

    #[Route(
        path: '',
        name: 'weekly_review_create',
        methods: ['GET'],
    )]
    public function form(): Response
    {
        return $this->render(
            'review/weekly/create.html.twig',
        );
    }

    /**
     * @throws \Exception
     */
    #[Route(
        path: '',
        name: 'weekly_review_store',
        methods: ['POST'],
    )]
    public function store(
        Request $request,
    ): RedirectResponse {
        $userId = UserId::fromString($this->getUser()->getUserIdentifier());
        try {
            $this->createWeeklyReviewUseCase->execute(
                new CreateWeeklyReviewInput(
                    userId: ($userId),
                    weekStartDate: new \DateTimeImmutable(
                        'monday this week',
                    ),
                    achievements: $request->request->get(
                        'achievements',
                    ),
                    lessonsLearned: $request->request->get(
                        'lessonsLearned',
                    ),
                    improvements: $request->request->get(
                        'improvements',
                    ),
                    nextWeekFocus: $request->request->get(
                        'nextWeekFocus',
                    ),
                ),
            );
            $this->addFlash(
                'success',
                'Weekly review created.',
            );
        }catch (\Exception $exception){

            $this->addFlash(
                'error',
                $exception->getMessage(),
            );

            return $this->redirectToRoute(
                'weekly_review_create',
            );
        }

        return $this->redirectToRoute(
            'weekly_review_list',
        );
    }
}
