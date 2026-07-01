<?php

declare(strict_types=1);

namespace App\Notification\Domain\ValueObject;

use Symfony\Component\Uid\Uuid;

final readonly class PushSubscriptionId
{
    private function __construct(
        private string $value,
    ) {
    }

    public static function generate(): self
    {
        return new self(
            Uuid::v7()->toRfc4122(),
        );
    }

    public static function fromString(
        string $value,
    ): self {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(
        self $other,
    ): bool {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
