<?php

declare(strict_types=1);

namespace App\Task\Domain\ValueObject;

final readonly class NextAction
{
    public function __construct(
        private string $value,
    ) {
        if (trim($value) === '') {
            throw new \InvalidArgumentException(
                'Next action cannot be empty.',
            );
        }
    }

    public static function fromString(
        string $value,
    ): self {
        return new self(
            $value,
        );
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
