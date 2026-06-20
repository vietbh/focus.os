<?php

namespace App\Identity\Domain\Repository;

use App\Identity\Domain\Entity\UserPreference;
use App\Identity\Domain\ValueObject\UserId;

interface UserPreferenceRepositoryInterface
{
    public function save(
        UserPreference $preference,
    ): void;

    public function getByUser(
        UserId $userId,
    ): ?UserPreference;
}
