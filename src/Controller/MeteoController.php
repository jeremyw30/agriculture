<?php 

namespace App\Controller;

use App\Entity\MeteoData;
use App\Repository\MeteoDataRepository;
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
    private const DEFAULT_ZONE = 'gavray';
    private const HOUR_RATIO = 3; // 1 heure réelle = 3 heures serveur

    public function __construct(
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

    // Ajouter un identifiant unique pour le timestamp du jour pour forcer le refresh du cache
    $today = (new \DateTime())->format('Ymd');
    $cacheKey = 'meteo_data_' . $zone . '_' . $today . '_v2';
    
    // Utiliser le cache avec la nouvelle clé
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