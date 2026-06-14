<?php

declare(strict_types=1);

namespace App\Inbox\Domain\Exception;

use App\SharedKernel\Domain\Exception\NotFoundException;

final class InboxItemNotFoundException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct(
            'Inbox item not found.',
        );
    }
}
