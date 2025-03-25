<?php
namespace App\Controller;

use App\Service\ServerTimeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(ServerTimeService $serverTimeService): Response
    {
        $serverTime = $serverTimeService->getServerTime();
return $this->render('game/index.html.twig', [
            'serverTime' => $serverTime,
        ]);
    }
}