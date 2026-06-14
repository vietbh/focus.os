<?php

declare(strict_types=1);

namespace App\Identity\Application\UseCase;

use App\Identity\Application\Provider\OAuthProviderInterface;
use App\Identity\Domain\Entity\User;

final readonly class LoginWithGoogleUseCase
{
    public function __construct(
        private OAuthProviderInterface $provider,
        private FindOrCreateUserUseCase $findOrCreateUser,
    ) {}

    public function execute(
        string $accessToken,
    ): User {
        $oauthUser = $this->provider
            ->fetchUser($accessToken);

        return $this->findOrCreateUser
            ->execute($oauthUser);
    }
}
