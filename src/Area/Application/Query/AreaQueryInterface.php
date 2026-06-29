<?php

namespace App\Area\Application\Query;

use Knp\Component\Pager\Pagination\PaginationInterface;

interface AreaQueryInterface
{
    public function paginate(
        AreaListCriteria $criteria
    ): PaginationInterface;
}
