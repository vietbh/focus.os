<?php

declare(strict_types=1);

namespace App\Goal\Infrastructure\Persistence\Doctrine\Type;

use App\Goal\Domain\ValueObject\GoalId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class GoalIdType extends Type
{
    public const NAME = 'goal_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(
        array $column,
        AbstractPlatform $platform,
    ): string {
        return $platform->getStringTypeDeclarationSQL(
            [
                'length' => 36,
                'fixed' => true,
            ],
        );
    }

    public function convertToDatabaseValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?string {
        if ($value === null) {
            return null;
        }

        return $value->value();
    }

    public function convertToPHPValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?GoalId {
        if ($value === null) {
            return null;
        }

        return GoalId::fromString(
            (string) $value,
        );
    }

    public function requiresSQLCommentHint(
        AbstractPlatform $platform,
    ): bool {
        return true;
    }
}
