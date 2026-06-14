<?php

declare(strict_types=1);

namespace App\Review\Application\UseCase;

use App\Review\Application\DTO\CreateDailyReviewInput;
use App\Review\Domain\Entity\DailyReview;
use App\Review\Domain\Repository\DailyReviewRepositoryInterface;
use App\Review\Domain\ValueObject\DailyReviewId;
use App\SharedKernel\Domain\Service\ClockInterface;
use Symfony\Component\Uid\Uuid;

final readonly class CreateDailyReviewUseCase
{
    public function __construct(
        private DailyReviewRepositoryInterface $dailyReviews,
        private ClockInterface $clock,
    ) {
    }

    public function execute(
        CreateDailyReviewInput $input,
    ): DailyReview {
        $existingReview = $this->dailyReviews->findByDate(
            $input->userId,
            $input->reviewDate,
        );

        if ($existingReview !== null) {
            throw new \RuntimeException(
                'Daily review already exists.',
            );
        }

        $dailyReview = DailyReview::create(
            id: DailyReviewId::fromString(
                Uuid::v7()->toRfc4122(),
            ),
            userId: $input->userId,
            reviewDate: $input->reviewDate,
            completedWork: $input->completedWork,
            wins: $input->wins,
            blockers: $input->blockers,
            focusTomorrow: $input->focusTomorrow,
            createdAt: $this->clock->now(),
        );

        $this->dailyReviews->save(
            $dailyReview,
        );

        return $dailyReview;
    }
}
