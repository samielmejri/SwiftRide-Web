<?php 

namespace App\Repository;

use App\Entity\Maintenance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Classroom>
 *
 * @method Maintenance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Maintenance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Maintenance[]    findAll()
 * @method Maintenance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

 class MaintenanceRepository extends ServiceEntityRepository 
 {

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry ,Maintenance::class);
    }


    public function save(Maintenance $entity , bool $flush =false):void
    {
        $this->getEntityManager()->persist($entity);
        if($flush){
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Maintenance $entity, bool $flush=false):void
    {
        $this->getEntityManager()->remove($entity);

        if($flush){
            $this->getEntityManager()->flush();
        }
    }


    public function getMaitenanceWithGarageAndDate($idg , $date){

        return $this->createQueryBuilder('m')
        ->join('m.idGarage','g')
        ->where('g.id LIKE :idg')
        ->andWhere(' SUBSTRING(m.dateMaintenance,1, 10) LIKE :date')
        ->setParameter('idg',$idg)
        ->setParameter('date',$date)
        ->getQuery()
        ->getResult();

    }

    public function getHistoMaintForClient($id){

        return $this->createQueryBuilder('m')
        ->join('m.idutilisateur','u')
        ->where('u.id= :id')
        ->setParameter('id',$id)
        ->getQuery()
        ->getResult();
    }

    public function getHistoMaintForEntreprise($id , $orde='ASC'){

        return $this->createQueryBuilder('m')
        ->join('m.identreprise','u')
        ->where('u.id= :id')
        ->OrderBy('m.dateMaintenance',$orde)
        ->setParameter('id',$id)
        
        ->getQuery()
        ->getResult();
    }

    
    public function getMaitenanceWithGarageAndDateCar( $date , $idv){

        return $this->createQueryBuilder('m')
        ->join('m.idGarage','g')
        ->join('m.idVoiture','v')
        ->where('v.id LIKE :idv')
        ->andWhere('m.dateMaintenance LIKE :date')
        ->setParameter('date',$date)
        ->setParameter('idv',$idv)
        ->getQuery()
        ->getResult();

    }


 }
