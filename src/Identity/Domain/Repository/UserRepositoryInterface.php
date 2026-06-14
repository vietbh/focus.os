<?php

declare(strict_types=1);

namespace App\Identity\Domain\Repository;

use App\Identity\Domain\Entity\User;
use App\Identity\Domain\ValueObject\UserId;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(
        UserId $id,
    ): ?User;

    public function findByProvider(
        string $providerId,
    ): ?User;
}
