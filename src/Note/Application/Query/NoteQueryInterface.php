<?php

namespace App\Note\Application\Query;

use Knp\Component\Pager\Pagination\PaginationInterface;

interface NoteQueryInterface
{
    public function paginate(
        NoteListCriteria $criteria
    ): PaginationInterface;
}
