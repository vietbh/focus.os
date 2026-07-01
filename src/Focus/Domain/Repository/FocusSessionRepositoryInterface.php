<?php

declare(strict_types=1);

namespace App\Focus\Domain\Repository;

use App\Focus\Domain\Entity\FocusSession;
use App\Focus\Domain\ValueObject\FocusSessionId;
use App\Identity\Domain\ValueObject\UserId;

interface FocusSessionRepositoryInterface
{
    public function save(FocusSession $session): void;

    public function remove(FocusSession $session): void;

    public function ofId(FocusSessionId $id): ?FocusSession;

    public function activeSessionOfUser(UserId $userId): ?FocusSession;
}
