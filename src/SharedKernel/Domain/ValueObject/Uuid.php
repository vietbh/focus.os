<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\ValueObject;

use Symfony\Component\Uid\Uuid as SymfonyUuid;

final readonly class Uuid
{
    public function __construct(
        private string $value
    ) {
    }

    public static function generate(): self
    {
        return new self(
            SymfonyUuid::v7()->toRfc4122()
        );
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
