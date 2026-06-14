<?php

declare(strict_types=1);

namespace App\Review\Application\UseCase;

use App\Review\Application\DTO\CreateWeeklyReviewInput;
use App\Review\Domain\Entity\WeeklyReview;
use App\Review\Domain\Repository\WeeklyReviewRepositoryInterface;
use App\Review\Domain\ValueObject\WeeklyReviewId;
use App\SharedKernel\Domain\Service\ClockInterface;
use Symfony\Component\Uid\Uuid;

final readonly class CreateWeeklyReviewUseCase
{
    public function __construct(
        private WeeklyReviewRepositoryInterface $weeklyReviews,
        private ClockInterface $clock,
    ) {
    }

    public function execute(
        CreateWeeklyReviewInput $input,
    ): WeeklyReview {
        $existingReview = $this->weeklyReviews
            ->findByWeekStartDate(
                $input->userId,
                $input->weekStartDate,
            );

        if ($existingReview !== null) {
            throw new \RuntimeException(
                'Weekly review already exists.',
            );
        }

        $weeklyReview = WeeklyReview::create(
            id: WeeklyReviewId::fromString(
                Uuid::v7()->toRfc4122(),
            ),
            userId: $input->userId,
            weekStartDate: $input->weekStartDate,
            achievements: $input->achievements,
            lessonsLearned: $input->lessonsLearned,
            improvements: $input->improvements,
            nextWeekFocus: $input->nextWeekFocus,
            createdAt: $this->clock->now(),
        );

        $this->weeklyReviews->save(
            $weeklyReview,
        );

        return $weeklyReview;
    }
}
