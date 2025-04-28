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

    public function findByDate($date)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.date = :date')
            ->setParameter('date', $date)
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
}