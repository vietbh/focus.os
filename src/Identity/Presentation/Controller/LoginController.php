<?php

declare(strict_types=1);

namespace App\Identity\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LoginController extends AbstractController
{
    #[Route(
        path: '/login',
        name: 'identity_login',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        return $this->render(
            view: '@identity/login.html.twig',
        );
    }
}
