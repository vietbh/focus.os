<?php

namespace App\SharedKernel\Domain\Service;

interface ClockInterface
{
    public function now(): \DateTimeImmutable;
}
