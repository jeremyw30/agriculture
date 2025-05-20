<?php

namespace App\Controller;

use App\Entity\MeteoData;
use App\Repository\MeteoDataRepository;
use App\Service\ServerTimeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class MeteoController extends AbstractController
{
    private const CACHE_EXPIRATION = 3600; // 1 heure réelle
    private const DEFAULT_ZONE = 'autun';

    public function __construct(
        private readonly ServerTimeService $serverTimeService,
        private readonly MeteoDataRepository $meteoDataRepository,
        private readonly CacheInterface $cache
    ) {
    }

    #[Route('/meteo/{zone}', name: 'app_meteo', defaults: ['zone' => null])]
    public function index(Request $request, SessionInterface $session, ?string $zone = null): Response
    {
        // Déterminer la zone (Autun ou Gavray)
        if ($zone !== null) {
            // Si une zone est spécifiée dans l'URL, l'utiliser et la sauvegarder dans la session
            $zone = strtolower($zone);
            if ($zone !== 'autun' && $zone !== 'gavray') {
                $zone = self::DEFAULT_ZONE;
            }
            $session->set('user_zone', $zone);
        } else {
            // Sinon, récupérer la zone depuis la session ou utiliser la valeur par défaut
            $zone = $session->get('user_zone', self::DEFAULT_ZONE);
        }

        // Utiliser le cache pour rafraîchir toutes les heures (avec une clé spécifique à la zone)
        $cacheKey = 'current_meteo_data_' . $zone;
        $meteoData = $this->cache->get($cacheKey, function (ItemInterface $item) use ($zone) {
            $item->expiresAfter(self::CACHE_EXPIRATION);
            return $this->getCurrentMeteoData($zone);
        });

        // Récupérer le temps serveur actuel
        $serverTime = $this->serverTimeService->getServerTime();

        return $this->render('meteo/index.html.twig', [
            'serverTime' => $serverTime,
            'meteoData' => $meteoData,
            'zone' => $zone
        ]);
    }

    private function getCurrentMeteoData(string $zone): ?MeteoData
    {
        // Récupérer le temps serveur
        $serverTime = $this->serverTimeService->getServerTime();
       
        // Extraire mois, jour et heure du temps serveur
        $serverMonth = (int)$serverTime['serverMonth'];
        $serverDay = (int)$serverTime['serverDay'];
        $serverHour = (int)$serverTime['serverHour'];
       
        // Chercher les données météo correspondantes en fonction de la zone
        // Format: 2024-MM-DD HH:00:00
        $date = new \DateTime();
        $date->setDate(2024, $serverMonth, $serverDay);
        $date->setTime($serverHour, 0, 0);
       
        // Chercher dans la base de données avec le critère de zone
        $meteoData = $this->meteoDataRepository->findByDateAndZone($date, $zone);
       
        // Si aucune donnée n'est trouvée, chercher la plus proche
        if (!$meteoData) {
            $meteoData = $this->meteoDataRepository->findClosestByDatetimeAndZone($date, $zone);
        }
       
        return $meteoData;
    }
}