<?php

declare(strict_types=1);

namespace App\Identity\Domain\Enum;

enum AuthProvider: string
{
    case GOOGLE = 'GOOGLE';
}
