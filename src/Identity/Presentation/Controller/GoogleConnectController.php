<?php

declare(strict_types=1);

namespace App\Identity\Presentation\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

final readonly class GoogleConnectController
{
    public function __construct(
        private ClientRegistry $clientRegistry,
    ) {
    }

    #[Route(
        path: '/connect/google',
        name: 'identity_google_connect',
        methods: ['GET'],
    )]
    public function connect(): RedirectResponse
    {
        return $this->clientRegistry
            ->getClient('google')
            ->redirect(
                [
                    'email',
                    'profile',
                ],
            );
    }
}
