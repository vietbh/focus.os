<?php

declare(strict_types=1);

namespace App\Area\Application\UseCase;

use App\Area\Application\DTO\UpdateAreaInput;
use App\Area\Domain\Repository\AreaRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;

final readonly class UpdateAreaUseCase
{
    public function __construct(
        private AreaRepositoryInterface $areas,
    ) {
    }

    public function execute(
        UpdateAreaInput $input,
        UserId $userId,
    ): void {
        $area = $this->areas->findById(
            $input->areaId,
        );

        if ($area === null) {
            throw new \RuntimeException(
                'Area not found.',
            );
        }
        if (
            !$area->ownedBy(
                $userId,
            )
        ) {
            throw new \RuntimeException(
                'Area not found.',
            );
        }
        $area->rename(
            $input->name,
            new \DateTimeImmutable()
        );

        $area->update(
            name: $input->name,
            goalId: $input->goalId,
        );

        $this->areas->save(
            $area,
        );
    }
}
