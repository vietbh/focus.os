<?php

declare(strict_types=1);

namespace App\Workspace\Application\UseCase;

use App\SharedKernel\Domain\Service\TransactionManagerInterface;
use App\Workspace\Application\Command\DeleteWorkspaceCommand;
use App\Workspace\Domain\Repository\WorkspaceRepositoryInterface;

final readonly class DeleteWorkspaceUseCase
{
    public function __construct(
        private WorkspaceRepositoryInterface $workspaceRepository,
        private TransactionManagerInterface $transactionManager,
    ) {
    }

    public function execute(
        DeleteWorkspaceCommand $command,
    ): void {
        $workspace = $this->workspaceRepository->get(
            $command->workspaceId,
        );

        $this->transactionManager->wrap(
            function () use ($workspace): void {
                $this->workspaceRepository->remove(
                    $workspace,
                );
            },
        );
    }
}
