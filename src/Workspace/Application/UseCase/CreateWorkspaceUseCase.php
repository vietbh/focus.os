<?php

declare(strict_types=1);

namespace App\Workspace\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\SharedKernel\Domain\Service\TransactionManagerInterface;
use App\SharedKernel\Domain\Uuid\UuidGeneratorInterface;
use App\Workspace\Application\Command\CreateWorkspaceCommand;
use App\Workspace\Domain\Entity\Workspace;
use App\Workspace\Domain\Exception\WorkspaceException;
use App\Workspace\Domain\Repository\WorkspaceRepositoryInterface;
use App\Workspace\Domain\ValueObject\WorkspaceId;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class CreateWorkspaceUseCase
{
    public function __construct(
        private WorkspaceRepositoryInterface $workspaceRepository,
        private UuidGeneratorInterface $uuidGenerator,
        private TransactionManagerInterface $transactionManager,
        private Security $security,
    ) {
    }

    public function execute(
        CreateWorkspaceCommand $command,
    ): Workspace {
        $owner = $this->security->getUser();

        $ownerId = UserId::fromString($owner->getUserIdentifier());
        $name = $command->name;

        if (
            $this->workspaceRepository->existsByOwnerAndName(
               $ownerId,
                $name,
            )
        ) {
            throw WorkspaceException::alreadyExists();
        }

        $workspace = new Workspace(
            id: WorkspaceId::fromString(
                $this->uuidGenerator->generate(),
            ),
            ownerId: $ownerId,
            name: $name,
            description: $command->description,
            icon: $command->icon,
            color: $command->color,
        );

        $this->transactionManager->wrap(
            function () use ($workspace): void {
                $this->workspaceRepository->save(
                    $workspace,
                );
            },
        );

        return $workspace;
    }
}
