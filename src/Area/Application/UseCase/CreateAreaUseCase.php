<?php

declare(strict_types=1);

namespace App\Area\Application\UseCase;

use App\Area\Application\DTO\CreateAreaInput;
use App\Area\Domain\Entity\Area;
use App\Area\Domain\Repository\AreaRepositoryInterface;
use App\Area\Domain\ValueObject\AreaId;
use Symfony\Component\Uid\Uuid;

final readonly class CreateAreaUseCase
{
    public function __construct(
        private AreaRepositoryInterface $areas,
    ) {
    }

    public function execute(
        CreateAreaInput $input,
    ): Area {
        $area = Area::create(
            id: AreaId::fromString(
                Uuid::v7()->toRfc4122(),
            ),
            userId: $input->userId,
            goalId: $input->goalId,
            name: $input->name,
            createdAt: new \DateTimeImmutable(),
        );

        $this->areas->save(
            $area,
        );

        return $area;
    }
}
