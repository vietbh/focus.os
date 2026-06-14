<?php

declare(strict_types=1);

namespace App\Review\Domain\Exception;

use App\SharedKernel\Domain\Exception\NotFoundException;

final class MonthlyReviewNotFoundException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct(
            'Monthly review not found.',
        );
    }
}
