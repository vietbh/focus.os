<?php

declare(strict_types=1);

namespace App\Workspace\Domain\Exception;

final class WorkspaceException extends \DomainException
{
    public static function notFound(): self
    {
        return new self(
            'Workspace not found.',
        );
    }

    public static function alreadyExists(): self
    {
        return new self(
            'Workspace already exists.',
        );
    }
}
