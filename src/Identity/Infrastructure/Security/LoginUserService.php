<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\Security;

use App\Identity\Domain\Entity\User;
use Symfony\Component\HttpFoundation\Request;

final readonly class LoginUserService
{
    public function login(
        User $user,
        Request $request,
    ): void {
    }
}
