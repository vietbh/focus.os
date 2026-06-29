<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Uuid;

use App\SharedKernel\Domain\Uuid\UuidGeneratorInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\Uid\Uuid;

#[AsAlias(UuidGeneratorInterface::class)]
final class SymfonyUuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::v7()->toRfc4122();
    }
}
