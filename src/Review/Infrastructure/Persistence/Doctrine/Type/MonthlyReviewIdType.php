<?php

declare(strict_types=1);

namespace App\Review\Infrastructure\Persistence\Doctrine\Type;

use App\Review\Domain\ValueObject\MonthlyReviewId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class MonthlyReviewIdType extends Type
{
    public const NAME = 'monthly_review_id';

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
    ): ?MonthlyReviewId {
        if ($value === null) {
            return null;
        }

        return MonthlyReviewId::fromString(
            (string) $value,
        );
    }

    public function requiresSQLCommentHint(
        AbstractPlatform $platform,
    ): bool {
        return true;
    }
}
