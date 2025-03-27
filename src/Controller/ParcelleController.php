<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ParcelleController extends AbstractController
{
    #[Route('/parcelle', name: 'app_parcelle')]
    public function index(): Response
    {
        return $this->render('parcelle/index.html.twig', [
            'controller_name' => 'ParcelleController',
        ]);
    }
}
