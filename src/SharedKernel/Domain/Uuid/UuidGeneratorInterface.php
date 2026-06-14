<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Uuid;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
