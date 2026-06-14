<?php

declare(strict_types=1);

namespace App\Identity\Presentation\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GoogleCallbackController
{
    #[Route(
        path: '/connect/google/check',
        name: 'identity_google_callback',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        throw new \LogicException(
            'Handled by GoogleAuthenticator.',
        );
    }
}
