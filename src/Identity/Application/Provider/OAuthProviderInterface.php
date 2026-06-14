<?php

declare(strict_types=1);

namespace App\Identity\Application\Provider;

use App\Identity\Application\DTO\OAuthUserData;

interface OAuthProviderInterface
{
    public function fetchUser(
        string $accessToken,
    ): OAuthUserData;
}
