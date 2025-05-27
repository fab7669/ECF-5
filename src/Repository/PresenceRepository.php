<?php


namespace App\Repository;

use App\Entity\Presence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Presence>
 */
class PresenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Presence::class);
    }

    public function save(Presence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Presence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    public function findByWeek(\DateTime $weekStart): array
    {
        $weekEnd = clone $weekStart;
        $weekEnd->modify('+6 days');
        
        return $this->createQueryBuilder('p')
            ->andWhere('p.date >= :start')
            ->andWhere('p.date <= :end')
            ->setParameter('start', $weekStart)
            ->setParameter('end', $weekEnd)
            ->orderBy('p.date', 'ASC')
            ->getQuery()
            ->getResult();
    }


public function findByMonthYear(int $month, int $year): array
{
    $firstDayOfMonth = new \DateTime("$year-$month-01");
    $firstDayOfNextMonth = (clone $firstDayOfMonth)->modify('+1 month');
    
    return $this->createQueryBuilder('p')
        ->andWhere('p.date >= :start')
        ->andWhere('p.date < :end')
        ->setParameter('start', $firstDayOfMonth)
        ->setParameter('end', $firstDayOfNextMonth)
        ->orderBy('p.date', 'ASC')
        ->getQuery()
        ->getResult();
}
}