<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\OAuth;

use App\Identity\Application\DTO\OAuthUserData;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Request;

final readonly class GoogleOAuthProvider
{
    public function __construct(
        private ClientRegistry $clientRegistry,
    ) {
    }

    public function getUserData(
        Request $request,
    ): OAuthUserData {
        $googleUser = $this->clientRegistry
            ->getClient('google')
            ->fetchUser();

        return new OAuthUserData(
            providerId: $googleUser->getId(),
            email: (string) $googleUser->getEmail(),
            name: (string) $googleUser->getName(),
            avatar: $googleUser->getAvatar(),
        );
    }
}
