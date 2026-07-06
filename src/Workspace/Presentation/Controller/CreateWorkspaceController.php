<?php

declare(strict_types=1);

namespace App\Workspace\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/workspaces/create',
)]
final class CreateWorkspaceController extends AbstractController
{
    #[Route(
        path: '',
        name: 'workspace_create',
        methods: ['GET'],
    )]
    public function create(): Response
    {
        return $this->render(
            'workspace/create.html.twig'
        );
    }
}
