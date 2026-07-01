<?php

declare(strict_types=1);

namespace App\Notification\Infrastructure\Persistence\Doctrine\Type;

use App\Notification\Domain\ValueObject\PushSubscriptionId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class PushSubscriptionIdType extends Type
{
    public const NAME = 'push_subscription_id';

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

        return $value->value();
    }

    public function convertToPHPValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?PushSubscriptionId {
        if ($value === null) {
            return null;
        }

        return PushSubscriptionId::fromString(
            (string) $value,
        );
    }

    public function requiresSQLCommentHint(
        AbstractPlatform $platform,
    ): bool {
        return true;
    }
}
