<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Accident;
use Doctrine\Persistence\ManagerRegistry;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Annonces;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use DoctrineExtensions\Query\Mysql\Month;
use App\Entity\Utilisateur;

class HomeAdminController extends AbstractController
{
    #[Route('/homeadmin', name: 'app_homeadmin')]
    
    public function accidentChart(ManagerRegistry $doctrine ,EntityManagerInterface $em, PaginatorInterface $paginator, Request $request,FlashyNotifier $flashy):Response{
    // retrieve the latest accidents
   
    $utilisateurRepository = $em->getRepository(Utilisateur::class);
    $repository = $em->getRepository(Accident::class);
    $repository2 = $em->getRepository(Annonces::class);
        // Query to count the number of accidents per year
        $result = $repository->getCountByYear();

        // Store data in arrays
        $years = array();
        $countsperyer = array();

        foreach ($result as $row) {
            $years[] = $row['year'];
            $countsperyer[] = $row['count'];
        }

        $result2 = $repository->getCountByvoiture();
        $voitures = array();
        $counts = array();

        foreach ($result2 as $row) {
            $voitures[] = $row['voiture'];
            $counts[] = $row['count'];
        }
        $result3 = $repository->getmodelByvoiture();
        $marques = array();
        $countsbymodel = array();

        foreach ($result3 as $row) {
            $marques[] = $row['marque'];
            $countsbymodel[] = $row['count'];
        }


        $result4 = $repository->getCountByMonth();
       
        $months = array();
        $countsbymonth = array();
        foreach ($result4 as $row) {
           $months[] =$row['month'];
           $countsbymonth[] =$row['count'];
            // Do whatever you need with the month value
        }
        $result = $repository->getCountByYearMonth();

// Initialize arrays to hold the data
$years = array();
$months = array();
$countsbymonthandyear = array();

// Loop through the results and extract the data
foreach ($result as $row) {
    $years[] = $row['year'];
    $months[] = $row['month'];
    $countsbymonthandyear[] = $row['count'];
}


$countAnByyear = $repository2->getCountByYear();
$yeara = array();
$countsa = array();
foreach ($countAnByyear as $row) {
    $yeara[] = $row['year'];
    $countsa[] = $row['count'];
    
}

// Combine the years and months into a single array
$labels = array();
for ($i = 0; $i < count($years); $i++) {
    $labels[] = $months[$i] . ' ' . $years[$i];
}
        $totalAccident = $repository->countTotalAccidents();
        $totalAnnoncement=$repository2->countTotalAnnoncement();
        $totalutilisateur= $utilisateurRepository->countTotalutilsateur();
        $data = $repository->getCountByYear();
        return $this->render('home_admin/index.html.twig', [
            'years' => $years,
             'counts' =>$counts,
             'yeara'=>$yeara,
             'marques'=>$marques,
             'countsperyer'=>$countsperyer,
             'countsbymodel'=>$countsbymodel,
             'countsa' => $countsa,
             'totalAccident'=>$totalAccident,
             'totalAnnoncement'=>$totalAnnoncement,
             'months'=>$months,
             'countsbymonth'=>$countsbymonth,
             'countsbymonthandyear'=>$countsbymonthandyear,
             'labels'=>$labels,
            
           
             'totalutilisateur'=>$totalutilisateur,
        ]);
    }
    private $flashy;

    public function __construct(FlashyNotifier $flashy)
    {
        $this->flashy = $flashy;
    }

    public function myAction(): Response
    {
        $this->flashy->success('Your success message');
        
        return $this->render('home_admin/index.html.twig');
    }
}


