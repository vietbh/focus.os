<?php

declare(strict_types=1);

namespace App\Note\Domain\Exception;

use App\SharedKernel\Domain\Exception\NotFoundException;

final class NoteNotFoundException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct(
            'Note not found.',
        );
    }
}
