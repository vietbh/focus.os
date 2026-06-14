<?php

declare(strict_types=1);

namespace App\Review\Application\UseCase;

use App\Review\Application\DTO\CreateMonthlyReviewInput;
use App\Review\Domain\Entity\MonthlyReview;
use App\Review\Domain\Repository\MonthlyReviewRepositoryInterface;
use App\Review\Domain\ValueObject\MonthlyReviewId;
use App\SharedKernel\Domain\Service\ClockInterface;
use Symfony\Component\Uid\Uuid;

final readonly class CreateMonthlyReviewUseCase
{
    public function __construct(
        private MonthlyReviewRepositoryInterface $monthlyReviews,
        private ClockInterface $clock,
    ) {
    }

    public function execute(
        CreateMonthlyReviewInput $input,
    ): MonthlyReview {
        $existingReview = $this->monthlyReviews
            ->findByMonth(
                $input->userId,
                $input->month,
            );

        if ($existingReview !== null) {
            throw new \RuntimeException(
                'Monthly review already exists.',
            );
        }

        $monthlyReview = MonthlyReview::create(
            id: MonthlyReviewId::fromString(
                Uuid::v7()->toRfc4122(),
            ),
            userId: $input->userId,
            month: $input->month,
            majorAchievements: $input->majorAchievements,
            goalProgress: $input->goalProgress,
            majorChallenges: $input->majorChallenges,
            lessonsLearned: $input->lessonsLearned,
            nextMonthFocus: $input->nextMonthFocus,
            createdAt: $this->clock->now(),
        );

        $this->monthlyReviews->save(
            $monthlyReview,
        );

        return $monthlyReview;
    }
}
