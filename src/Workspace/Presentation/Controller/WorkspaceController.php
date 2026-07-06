<?php

declare(strict_types=1);

namespace App\Workspace\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/workspaces',
)]
final class WorkspaceController extends AbstractController
{


    #[Route(
        path: '',
        name: 'workspace_list',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        return $this->render(
            'workspace/list.html.twig'
        );
    }
}
