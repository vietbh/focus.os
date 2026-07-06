<?php

namespace App\Twig\Components\Workspace;

use App\Identity\Domain\ValueObject\UserId;
use App\SharedKernel\Presentation\LiveComponent\WithPagination;
use App\SharedKernel\Presentation\LiveComponent\WithSearch;
use App\SharedKernel\Presentation\LiveComponent\WithSorting;
use App\Workspace\Application\Query\WorkspaceListCriteria;
use App\Workspace\Application\Query\WorkspaceQueryInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
final class ListWorkspaces extends AbstractController
{
    use DefaultActionTrait;
    use WithPagination;
    use WithSearch;
    use WithSorting;


    public function __construct(
        private readonly WorkspaceQueryInterface $workspaceQuery,
    )
    {
    }

    #[ExposeInTemplate]
    public function pagination(): PaginationInterface
    {
        return $this->workspaceQuery->paginate(
            new WorkspaceListCriteria(
                ownerId: $this->userId(),
                search: $this->search,
                page: $this->page,
                perPage: $this->perPage,
                sort: $this->sort,
                direction: $this->direction,
            )
        );
    }

    public function userId(): UserId
    {
        $user = $this->getUser();

        if ($user === null) {
            throw $this->createAccessDeniedException();
        }
        return UserId::fromString($user->getUserIdentifier());
    }
}
