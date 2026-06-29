<?php

declare(strict_types=1);

namespace App\Area\Presentation\Controller;

use App\Area\Application\UseCase\GetAreaListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/areas',
)]
final class AreaController extends AbstractController
{


    #[Route(
        path: '',
        name: 'area_list',
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        return $this->render(
            'area/list.html.twig',
            [

            ],
        );
    }
}
