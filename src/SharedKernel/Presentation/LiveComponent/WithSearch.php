<?php

declare(strict_types=1);

namespace App\SharedKernel\Presentation\LiveComponent;

use Symfony\UX\LiveComponent\Attribute\LiveProp;

trait WithSearch
{
    #[LiveProp(writable: true, url: true)]
    public string $search = '';

    public function clearSearch(): void
    {
        $this->search = '';
    }

    protected function resetSearch(): void
    {
        $this->search = '';
    }
}
