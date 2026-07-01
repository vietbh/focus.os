<?php

declare(strict_types=1);

namespace App\Focus\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/focus', name: 'focus_')]
final class FocusController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render(
            'focus/index.html.twig',
        );
    }
}
