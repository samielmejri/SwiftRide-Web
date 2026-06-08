<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Accident;
use App\Entity\Annonces;
use App\Entity\Avis;
use App\Entity\EntreprisePartenaire;
use App\Entity\Utilisateur;
use App\Entity\Voiture;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'chart')]
    public function chart(ManagerRegistry $doctrine ,EntityManagerInterface $em,): Response
    {
   
    $repository = $em->getRepository(Voiture::class);
    $repository2 = $em->getRepository(EntreprisePartenaire::class);
    
    
    $totalVoiture = $repository->countTotalVoiture();
    $totalEntreprise=$repository2->countTotalentreprise();
    $countAnByyear = $repository->getCountByYear();
    $years = array();
    $counts = array();
    foreach ($countAnByyear as $row) {
        $years[] = $row['year'];
        $counts[] = $row['count'];
        
    }

    $result = $repository->getCountvoitureByMonth();
    $months = array();
    $countv = array();
    foreach ($result as $row) {
        $months[] = $row['month'];
        $countv[] = $row['count'];
        
    }
    


        return $this->render('chart/index.html.twig', [
            'totalVoiture'=>$totalVoiture,
            'totalEntreprise'=>$totalEntreprise,
            'years'=>$years,
            'counts'=>$counts,
            'months'=>$months,
            'countv'=>$countv,
            
        ]);
       
    }
}
