<?php

namespace App\Twig\Components\Note;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Application\Query\NoteListCriteria;
use App\Note\Infrastructure\Persistence\Query\DoctrineNoteQuery;
use App\SharedKernel\Presentation\LiveComponent\WithPagination;
use App\SharedKernel\Presentation\LiveComponent\WithSearch;
use App\SharedKernel\Presentation\LiveComponent\WithSorting;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
final class ListNotes extends AbstractController
{
    use DefaultActionTrait;
    use WithPagination;
    use WithSearch;
    use WithSorting;

    public function __construct(
        private readonly DoctrineNoteQuery $noteQuery,
    ) {
    }

    #[ExposeInTemplate]
    public function pagination(): PaginationInterface
    {
        return $this->noteQuery->paginate(
            new NoteListCriteria(
                userId: UserId::fromString($this->getUser()->getUserIdentifier()),
                search: $this->search,
                sort: $this->sort,
                direction: $this->direction,
                page: $this->page,
                perPage: $this->perPage,
            )
        );
    }



}
