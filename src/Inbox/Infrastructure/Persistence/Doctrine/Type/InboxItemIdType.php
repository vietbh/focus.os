<?php

declare(strict_types=1);

namespace App\Inbox\Infrastructure\Persistence\Doctrine\Type;

use App\Inbox\Domain\ValueObject\InboxItemId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class InboxItemIdType extends Type
{
    public const NAME = 'inbox_item_id';

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
    ): ?InboxItemId {
        if ($value === null) {
            return null;
        }

        return InboxItemId::fromString(
            (string) $value,
        );
    }

    public function requiresSQLCommentHint(
        AbstractPlatform $platform,
    ): bool {
        return true;
    }
}
