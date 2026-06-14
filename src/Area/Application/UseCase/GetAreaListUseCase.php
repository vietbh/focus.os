<?php

declare(strict_types=1);

namespace App\Area\Application\UseCase;

use App\Area\Domain\Repository\AreaRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;

final readonly class GetAreaListUseCase
{
    public function __construct(
        private AreaRepositoryInterface $areas,
    ) {
    }

    public function execute(
        string $userId,
    ): array {
        return $this->areas->findByUserId(
            UserId::fromString($userId),
        );
    }
}
