<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ServerTimeService;

final class MeteoController extends AbstractController
{
    #[Route('/meteo', name: 'app_meteo')]
    public function index(ServerTimeService $serverTimeService): Response
    {
        $serverTime = $serverTimeService->getServerTime();

        return $this->render('meteo/index.html.twig', [
            'serverTime' => $serverTime,
        ]);
    }
}
