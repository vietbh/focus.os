<?php

declare(strict_types=1);

namespace App\Workspace\Application\UseCase;

use App\SharedKernel\Domain\Service\TransactionManagerInterface;
use App\Workspace\Application\Command\UpdateWorkspaceCommand;
use App\Workspace\Domain\Exception\WorkspaceException;
use App\Workspace\Domain\Repository\WorkspaceRepositoryInterface;

final readonly class UpdateWorkspaceUseCase
{
    public function __construct(
        private WorkspaceRepositoryInterface $workspaceRepository,
        private TransactionManagerInterface $transactionManager,
    ) {
    }

    public function execute(
        UpdateWorkspaceCommand $command,
    ): void {
        $workspace = $this->workspaceRepository->find(
            $command->workspaceId,
        );

        if ($workspace === null) {
            throw WorkspaceException::notFound();
        }

        $workspace->rename(
            $command->name,
        );

        $workspace->changeDescription(
            $command->description,
        );

        $workspace->changeAppearance(
            $command->icon,
            $command->color,
        );

        $this->transactionManager->wrap(
            function () use ($workspace): void {
                $this->workspaceRepository->save(
                    $workspace,
                );
            },
        );
    }
}
