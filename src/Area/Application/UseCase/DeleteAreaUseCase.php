<?php

declare(strict_types=1);

namespace App\Area\Application\UseCase;

use App\Area\Domain\Repository\AreaRepositoryInterface;
use App\Area\Domain\ValueObject\AreaId;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\Repository\TaskRepositoryInterface;

final readonly class DeleteAreaUseCase
{
    public function __construct(
        private AreaRepositoryInterface $areas,
        private TaskRepositoryInterface $tasks,
    ) {
    }

    public function execute(
        AreaId $areaId,
        UserId $userId,
    ): void {
        $area = $this->areas->findById(
            $areaId,
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

        if (
            $this->areas->countByUserId(
                $area->userId(),
            ) <= 1
        ) {
            throw new \RuntimeException(
                'Cannot delete last area.',
            );
        }

        if (
            $this->tasks->countByAreaId(
                $areaId,
            ) > 0
        ) {
            throw new \RuntimeException(
                'Cannot delete area with tasks.',
            );
        }

        $this->areas->remove(
            $area,
        );
    }
}
