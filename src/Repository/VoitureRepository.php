<?php

namespace App\Repository;

use App\Entity\Voiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Voiture>
 *
 * @method Voiture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voiture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voiture[]    findAll()
 * @method Voiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voiture::class);
    }

    public function save(Voiture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Voiture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findAvailableVoituresQueryBuilder()
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.etat = :etat')
            ->setParameter('etat', 'Bonne etat')
            ->orderBy('v.marque', 'ASC')
            ->getQuery()
            ->getResult();

    }
    public function getCountByYear()
    {
        $qb = $this->createQueryBuilder('v');

        $qb->select('YEAR(v.dateCirculation) AS year, COUNT(v.id) AS count')
           ->groupBy('year')
           ->orderBy('year');

        return $qb->getQuery()->getArrayResult();
    }
    public function getCountBymodel()
    {
        $qb = $this->createQueryBuilder('v');

        $qb->select('v.model AS model, COUNT(v.id) AS count')
           ->groupBy('model')
           ->orderBy('model');

        return $qb->getQuery()->getArrayResult();
    }
    public function getCountvoitureByMonth()
    {
        $qb = $this->createQueryBuilder('v');
        $qb->select('MONTHNAME(v.dateCirculation) AS month')
           ->addSelect('COUNT(v.id) AS count')
           ->groupBy('month')
           ->orderBy('month');
        
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
    public function countTotalVoiture(): int
    {
        $qb = $this->createQueryBuilder('v');
        
        $qb->select($qb->expr()->count('v.id'));
        
        return (int) $qb->getQuery()->getSingleScalarResult();
    }
    
//    /**
//     * @return Voiture[] Returns an array of Voiture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Voiture
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
