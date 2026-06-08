<?php

namespace App\Repository;

use App\Entity\Accident;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Mysql\Month;

/**
 * @extends ServiceEntityRepository<Accident>
 *
 * @method Accident|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accident|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accident[]    findAll()
 * @method Accident[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccidentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry ,)
    {
        parent::__construct($registry, Accident::class);
    }

    public function save(Accident $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Accident $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getCountByYear()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('YEAR(a.date) AS year, COUNT(a.id) AS count')
           ->groupBy('year')
           ->orderBy('year');

        return $qb->getQuery()->getArrayResult();
    }
    public function getCountByvoiture()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('(a.idVoiture) AS voiture, COUNT(a.id) AS count')
           ->groupBy('voiture')
           ->orderBy('count', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }
    public function getmodelByvoiture()
    {
        $qb = $this->createQueryBuilder('a')
           ->select('v.marque AS marque, COUNT(a.id) AS count')
           ->leftJoin('App\Entity\Voiture', 'v', 'WITH', 'a.idVoiture = v.id')
           ->groupBy('marque')
           ->orderBy('count', 'DESC');

        return $qb->getQuery()->getArrayResult();
    }
    public function countTotalAccidents(): int
{
    $dql = 'SELECT COUNT(a.id) FROM App\Entity\Accident a';
    
    return (int) $this->_em->createQuery($dql)->getSingleScalarResult();
}

    public function getCountByMonth()
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('MONTHNAME(a.date) AS month')
           ->addSelect('COUNT(a.id) AS count')
           ->groupBy('month')
           ->orderBy('month');
        
        return $qb->getQuery()->getArrayResult();
    }
    public function getCountByYearMonth()
{
    $qb = $this->createQueryBuilder('a');
    $qb->select('YEAR(a.date) AS year')
       ->addSelect('MONTHNAME(a.date) AS month')
       ->addSelect('COUNT(a.id) AS count')
       ->groupBy('year, month')
       ->orderBy('year, month');
    
    return $qb->getQuery()->getArrayResult();
}
public function getAvgAccidentsPerYearByType()
{
    $qb = $this->createQueryBuilder('a');
    $qb->select('a.type AS type')
       ->addSelect('AVG(COUNT(a.id)) AS avg')
       ->addSelect('YEAR(a.date) AS year')
       ->groupBy('year, type')
       ->orderBy('type, year');
    
    return $qb->getQuery()->getArrayResult();
}

  


    
//    /**
//     * @return Accident[] Returns an array of Accident objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Accident
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
