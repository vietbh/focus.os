<?php

declare(strict_types=1);

namespace App\SharedKernel\Presentation\LiveComponent;

use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

trait WithSorting
{
    #[LiveProp(writable: true, url: true)]
    public string $sort = 'createdAt';

    #[LiveProp(writable: true, url: true)]
    public string $direction = 'desc';

    #[LiveAction]
    public function sortBy(string $field): void
    {
        if ($this->sort === $field) {
            $this->direction = $this->direction === 'asc'
                ? 'desc'
                : 'asc';

            return;
        }

        $this->sort = $field;
        $this->direction = 'asc';
    }
}
