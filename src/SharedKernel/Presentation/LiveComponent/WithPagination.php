<?php

declare(strict_types=1);

namespace App\SharedKernel\Presentation\LiveComponent;

use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

trait WithPagination
{
    #[LiveProp(writable: true, url: true)]
    public int $page = 1;

    #[LiveProp(writable: true, url: true)]
    public int $perPage = 20;

    #[LiveAction]
    public function gotoPage(int $page): void
    {
        $this->page = max(1, $page);
    }

    #[LiveAction]
    public function nextPage(): void
    {
        ++$this->page;
    }

    #[LiveAction]
    public function previousPage(): void
    {
        $this->page = max(
            1,
            $this->page - 1
        );
    }

    protected function resetPage(): void
    {
        $this->page = 1;
    }
}
