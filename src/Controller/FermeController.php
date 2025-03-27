<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FermeController extends AbstractController
{
    #[Route('/ferme', name: 'app_ferme')]
    public function index(): Response
    {
        return $this->render('ferme/index.html.twig', [
            'controller_name' => 'FermeController',
        ]);
    }
}
