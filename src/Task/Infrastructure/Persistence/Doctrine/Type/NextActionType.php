<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence\Doctrine\Type;

use App\Task\Domain\ValueObject\NextAction;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class NextActionType extends Type
{
    public const NAME = 'next_action';

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
                'length' => 500,
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
    ): ?NextAction {
        if ($value === null) {
            return null;
        }

        return NextAction::fromString(
            (string) $value,
        );
    }

    public function requiresSQLCommentHint(
        AbstractPlatform $platform,
    ): bool {
        return true;
    }
}
