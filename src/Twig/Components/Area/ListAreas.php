<?php

namespace App\Twig\Components\Area;

use App\Area\Application\Query\AreaListCriteria;
use App\Area\Infrastructure\Persistence\Query\DoctrineAreaQuery;
use App\SharedKernel\Presentation\LiveComponent\WithPagination;
use App\SharedKernel\Presentation\LiveComponent\WithSearch;
use App\SharedKernel\Presentation\LiveComponent\WithSorting;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
final class ListAreas extends AbstractController
{
    use DefaultActionTrait;
    use WithPagination;
    use WithSearch;
    use WithSorting;

    public function __construct(
        private readonly DoctrineAreaQuery $areaQuery,
    ) {
    }

    #[ExposeInTemplate]
    public function pagination(): PaginationInterface
    {
        return $this->areaQuery->paginate(
            new AreaListCriteria(
                userId: $this->userId(),
                search: $this->search,
                sort: $this->sort,
                direction: $this->direction,
                page: $this->page,
                perPage: $this->perPage,
            )
        );
    }

    public function userId(): string
    {
        $user = $this->getUser();

        if ($user === null) {
            throw $this->createAccessDeniedException();
        }
        return $user->getUserIdentifier();
    }
}
