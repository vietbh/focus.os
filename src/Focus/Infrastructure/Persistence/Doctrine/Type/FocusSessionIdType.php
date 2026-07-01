<?php

declare(strict_types=1);

namespace App\Focus\Infrastructure\Persistence\Doctrine\Type;

use App\Focus\Domain\ValueObject\FocusSessionId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class FocusSessionIdType extends Type
{
    public const NAME = 'focus_session_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(
        array $column,
        AbstractPlatform $platform,
    ): string {
        return $platform->getStringTypeDeclarationSQL([
            'length' => 36,
            'fixed' => true,
        ]);
    }

    public function convertToDatabaseValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?string {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof FocusSessionId) {
            throw new \InvalidArgumentException(sprintf(
                'Expected %s, got %s.',
                FocusSessionId::class,
                get_debug_type($value),
            ));
        }

        return $value->value();
    }

    public function convertToPHPValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?FocusSessionId {
        if ($value === null) {
            return null;
        }

        if ($value instanceof FocusSessionId) {
            return $value;
        }

        return FocusSessionId::fromString(
            (string) $value,
        );
    }

    public function requiresSQLCommentHint(
        AbstractPlatform $platform,
    ): bool {
        return true;
    }
}
