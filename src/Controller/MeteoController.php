<?php

namespace App\Controller;

use App\Entity\MeteoData;
use App\Entity\User;
use App\Repository\MeteoDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class MeteoController extends AbstractController
{
    private const CACHE_EXPIRATION = 3600; // 1 heure réelle
    private const DEFAULT_ZONE = 'gavray';

    public function __construct(
        private readonly MeteoDataRepository $meteoDataRepository,
        private readonly CacheInterface $cache
    ) {
    }

    // Widget météo pour la sidebar (appelé par render() dans base.html.twig)
    public function index(): Response
    {
        // Déterminer la zone : utilisateur connecté ou défaut
        $user = $this->getUser();
        $zone = ($user instanceof User) ? 
            ($user->getZone() ?? self::DEFAULT_ZONE) : 
            self::DEFAULT_ZONE;

        // Cache basé sur l'heure réelle (change chaque heure réelle)
        $realHour = (new \DateTime())->format('YmdH');
        $cacheKey = 'meteo_widget_' . $zone . '_' . $realHour;
        
        // Charger les données météo avec cache
        $meteoData = $this->cache->get($cacheKey, function (ItemInterface $item) use ($zone) {
            $item->expiresAfter(self::CACHE_EXPIRATION);
            return $this->getCurrentMeteoData($zone);
        });

        // Calculer le temps serveur pour l'affichage
        $serverTime = $this->calculateServerTime();

        return $this->render('meteo/index.html.twig', [
            'meteoData' => $meteoData,
            'zone' => $zone,
            'serverTime' => $serverTime
        ]);
    }

    private function getCurrentMeteoData(string $zone): ?MeteoData
    {
        // Calculer le temps serveur basé sur le temps réel avec ratio 1:3
        $serverTime = $this->calculateServerTime();
        
        // Chercher les données météo correspondantes en fonction de la zone
        $date = new \DateTime();
        $date->setDate(2024, $serverTime['month'], $serverTime['day']);
        $date->setTime($serverTime['hour'], 0, 0);
        
        // Chercher dans la base de données avec le critère de zone
        $meteoData = $this->meteoDataRepository->findByDateAndZone($date, $zone);
        
        // Si aucune donnée n'est trouvée, chercher la plus proche
        if (!$meteoData) {
            $meteoData = $this->meteoDataRepository->findClosestByDatetimeAndZone($date, $zone);
        }
        
        return $meteoData;
    }
    
    private function calculateServerTime(): array
    {
        // Récupérer le temps réel actuel
        $now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        
        // Créer la date serveur et simplement ajouter 3 heures
        $serverDate = clone $now;
        $serverDate->modify('+3 hours');
        
        // Format français: jour/mois à heure:00
        $formattedDate = $serverDate->format('d/m');
        $formattedTime = $serverDate->format('H\h00');
        
        return [
            'month' => (int)$serverDate->format('n'),
            'day' => (int)$serverDate->format('j'),
            'hour' => (int)$serverDate->format('G'),
            'formattedDateTime' => $formattedDate . ' à ' . $formattedTime
        ];
    }
}