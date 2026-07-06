<?php

declare(strict_types=1);

namespace App\Workspace\Application\UseCase;

use App\Identity\Domain\Repository\UserPreferenceRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;
use App\SharedKernel\Domain\Service\TransactionManagerInterface;
use App\Workspace\Application\Command\SwitchWorkspaceCommand;
use App\Workspace\Domain\Repository\WorkspaceRepositoryInterface;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class SwitchWorkspaceUseCase
{
    public function __construct(
        private UserPreferenceRepositoryInterface $preferenceRepository,
        private TransactionManagerInterface       $transactionManager,
        private UserPreferenceRepositoryInterface $userPreferenceRepository,
        private Security $security,
    ) {
    }

    public function execute(
        SwitchWorkspaceCommand $command,
    ): void {

        $preference = $this->userPreferenceRepository
            ->getByUser(
                UserId::fromString(
                    $this->security
                        ->getUser()
                        ->getUserIdentifier()
                ),
            );

        $preference->switchWorkspaceId(
            $command->workspaceId,
        );

        $this->transactionManager->wrap(
            function () use ($preference): void {
                $this->preferenceRepository->save(
                    $preference,
                );
            },
        );
    }

    public function currentWorkspaceId(): ?string
    {
        return $this->userPreferenceRepository
            ->getByUser(
                UserId::fromString(
                    $this->security
                        ->getUser()
                        ->getUserIdentifier()
                ),
            )
            ->currentWorkspaceId()
            ?->value();
    }

}
