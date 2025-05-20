<?php
namespace App\Repository;

use App\Entity\MeteoData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MeteoDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeteoData::class);
    }

    public function findByDateAndZone(\DateTimeInterface $date, string $zone)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.date = :date')
            ->andWhere('m.zone = :zone')
            ->setParameter('date', $date)
            ->setParameter('zone', $zone)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllOrderedByDate()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve l'entrée météo la plus proche d'une date/heure donnée pour une zone spécifique
     * (ignorer l'année, uniquement considérer mois/jour/heure)
     */
    public function findClosestByDatetimeAndZone(\DateTimeInterface $dateTime, string $zone)
    {
        $month = $dateTime->format('m');
        $day = $dateTime->format('d');
        $hour = $dateTime->format('H');

        return $this->createQueryBuilder('m')
            ->andWhere('MONTH(m.date) = :month')
            ->andWhere('DAY(m.date) = :day')
            ->andWhere('HOUR(m.date) = :hour')
            ->andWhere('m.zone = :zone')
            ->setParameter('month', $month)
            ->setParameter('day', $day)
            ->setParameter('hour', $hour)
            ->setParameter('zone', $zone)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}