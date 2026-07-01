<?php

namespace App\Focus\Domain\Service;

use App\Focus\Domain\Entity\FocusSession;

interface FocusDurationCalculator
{
    public function calculate(
        FocusSession $session,
    ): int;
}
