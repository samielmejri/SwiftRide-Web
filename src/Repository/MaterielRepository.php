<?php 

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Classroom>
 *
 * @method Materiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Materiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Materiel[]    findAll()
 * @method Materiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

 class MaterielRepository extends  ServiceEntityRepository 
 {
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry ,Materiel::class);
    }

    public function save(Materiel $entity , bool $flush =false):void
    {
        $this->getEntityManager()->persist($entity);
        if($flush){
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Materiel $entity, bool $flush=false):void
    {
        $this->getEntityManager()->remove($entity);

        if($flush){
            $this->getEntityManager()->flush();
        }
    }


    public function getMaterielWithGarageId($id)
    {
        return $this->createQueryBuilder('m')
        ->join('m.idGarage','g')
        ->where('g.id= :id')
        ->setParameter('id',$id)
        ->getQuery()
        ->getResult();
    }
 }
 