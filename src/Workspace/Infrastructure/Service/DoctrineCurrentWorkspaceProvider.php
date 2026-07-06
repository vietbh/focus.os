<?php

declare(strict_types=1);

namespace App\Workspace\Infrastructure\Service;

use App\Identity\Application\Service\CurrentWorkspaceProviderInterface;
use App\Identity\Domain\Repository\UserPreferenceRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;
use App\Workspace\Domain\Entity\Workspace;
use App\Workspace\Domain\Exception\WorkspaceException;
use App\Workspace\Domain\Repository\WorkspaceRepositoryInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final readonly class DoctrineCurrentWorkspaceProvider implements CurrentWorkspaceProviderInterface
{
    public function __construct(
        private Security $security,
        private UserPreferenceRepositoryInterface $userPreferenceRepository,
        private WorkspaceRepositoryInterface $workspaceRepository,
    ) {
    }

    public function current(): ?Workspace
    {
        $user = $this->security->getUser();

        if ($user === null) {
            throw new AccessDeniedException('User is not authenticated.');
        }

        $preference = $this->userPreferenceRepository->getByUser(
            UserId::fromString(
                $user->getUserIdentifier(),
            ),
        );

        $workspaceId = $preference->currentWorkspaceId();

        if ($workspaceId === null) {
            throw WorkspaceException::notFound();
        }

        return $this->workspaceRepository->get(
            $workspaceId,
        );
    }
}
