<?php

namespace App\Repository;

use App\Entity\MoyenTransportStation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MoyenStation>
 *
 * @method MoyenTransportStation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoyenTransportStation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoyenTransportStation[]    findAll()
 * @method MoyenTransportStation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoyenTransportStationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoyenTransportStation::class);
    }

    public function save(MoyenTransportStation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MoyenTransportStation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MoyenTransportStation[] Returns an array of MoyenStation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MoyenTransportStation
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
