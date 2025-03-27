<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BatimentController extends AbstractController
{
    #[Route('/batiment', name: 'app_batiment')]
    public function index(): Response
    {
        return $this->render('batiment/index.html.twig', [
            'controller_name' => 'BatimentController',
        ]);
    }
}
