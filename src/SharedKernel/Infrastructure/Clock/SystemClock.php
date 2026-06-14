<?php

namespace App\SharedKernel\Infrastructure\Clock;

use App\SharedKernel\Domain\Service\ClockInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(ClockInterface::class)]
final class SystemClock implements ClockInterface
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
