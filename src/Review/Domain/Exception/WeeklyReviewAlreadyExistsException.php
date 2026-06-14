<?php

declare(strict_types=1);

namespace App\Review\Domain\Exception;

use App\SharedKernel\Domain\Exception\NotFoundException;

final class WeeklyReviewAlreadyExistsException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct(
            'Weekly review not found.',
        );
    }
}
