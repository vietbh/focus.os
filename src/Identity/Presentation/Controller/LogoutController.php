<?php

declare(strict_types=1);

namespace App\Identity\Presentation\Controller;

use Symfony\Component\Routing\Annotation\Route;


final class LogoutController
{
    #[Route('/logout', name: 'identity_logout')]
    public function __invoke(): never
    {
        throw new \LogicException(
            'Handled by Symfony Security.',
        );
    }
}
