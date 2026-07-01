<?php

declare(strict_types=1);

namespace App\Identity\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    '/profile',
    name: 'profile_'
)]
final class ProfileController extends AbstractController
{

    #[Route(
        '',
        name: 'index'
    )]
    public function __invoke(): Response
    {
        return $this->render(
            'identity/profile/index.html.twig',
        );
    }

}
