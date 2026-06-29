<?php

namespace App\Goal\Application\Query;

use Knp\Component\Pager\Pagination\PaginationInterface;

interface GoalQueryInterface
{
    public function paginate(
        GoalListCriteria $criteria
    ): PaginationInterface;
}
