<?php

declare(strict_types=1);

namespace App\Focus\Application\Query;


use App\Identity\Domain\ValueObject\UserId;

final readonly class CurrentFocusSessionQuery
{
    public function __construct(
        public UserId $userId,
    ) {
    }
}
