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




}