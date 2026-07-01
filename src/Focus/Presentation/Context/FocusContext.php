<?php

namespace App\Focus\Presentation\Context;

use App\Focus\Application\DTO\FocusSessionDto;
use App\Identity\Domain\ValueObject\UserId;

interface FocusContext
{
    public function userId(): UserId;

    public function currentSession(): ?FocusSessionDto;
}
