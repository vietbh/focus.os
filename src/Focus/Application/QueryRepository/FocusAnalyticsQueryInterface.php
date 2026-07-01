<?php

declare(strict_types=1);

namespace App\Focus\Application\QueryRepository;

use App\Focus\Application\DTO\FocusSessionDto;
use App\Identity\Domain\ValueObject\UserId;

interface FocusAnalyticsQueryInterface
{
    public function currentOfUser(
        UserId $userId,
    ): ?FocusSessionDto;

    /**
//     * @return FocusHistoryItemDto[]
     */
    public function history(
        UserId $userId,
        int $limit = 30,
    ): array;

}
