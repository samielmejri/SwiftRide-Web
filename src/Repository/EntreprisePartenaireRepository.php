<?php

namespace App\Repository;

use App\Entity\EntreprisePartenaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EntreprisePartenaire>
 *
 * @method EntreprisePartenaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntreprisePartenaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntreprisePartenaire[]    findAll()
 * @method EntreprisePartenaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntreprisePartenaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntreprisePartenaire::class);
    }

    public function save(EntreprisePartenaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EntreprisePartenaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllWithCommentaires(): array
{
    return $this->createQueryBuilder('e')
        ->leftJoin('e.commentaires', 'c')
        ->addSelect('c')
        ->getQuery()
        ->getResult()
    ;
}
public function countTotalentreprise(): int
    {
        $qb = $this->createQueryBuilder('e');
        
        $qb->select($qb->expr()->count('e.id'));
        
        return (int) $qb->getQuery()->getSingleScalarResult();
    }
    

//    /**
//     * @return EntreprisePartenaire[] Returns an array of EntreprisePartenaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EntreprisePartenaire
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
