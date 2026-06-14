<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Service;

interface TransactionManagerInterface
{
    public function wrap(
        callable $callback,
    ): mixed;
}
