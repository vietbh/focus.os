<?php

namespace App\Task\Application\Query;

use Knp\Component\Pager\Pagination\PaginationInterface;

interface TaskQueryInterface
{
    public function paginate(
        TaskListCriteria $criteria
    ): PaginationInterface;
}
