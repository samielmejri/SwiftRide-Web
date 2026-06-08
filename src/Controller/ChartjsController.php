<?php

namespace App\Controller;

use App\Entity\Annonces;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\AccidentRepository;
use Doctrine\ORM\EntityManagerInterface;



class ChartjsController extends AbstractController
{
    #[Route('/chartjs', name: 'app_chartjs')]
    public function index(AccidentRepository $accidentRepository,EntityManagerInterface $em): Response
    {
       
$repository = $em->getRepository(Annonces::class);

// Query to count the number of records per year
$result = $repository->getCountByYear();

// Store data in arrays
$years = array();
$countsPerYear = array();

foreach ($result as $row) {
    $years[] = $row['year'];
    $countsPerYear[] = $row['count'];
}


// Query to count the number of records per voiture
$result2 = $repository->getCountByvoiture();

// Store data in arrays
$voitures = array();
$countsPerVoiture = array();

foreach ($result2 as $row) {
    $voitures[] = $row['voiture'];
    $countsPerVoiture[] = $row['count'];
}


// Query to count the number of records per marque
$result3 = $repository->getmodelByvoiture();

// Store data in arrays
$marques = array();
$countsPerMarque = array();

foreach ($result3 as $row) {
    $marques[] = $row['marque'];
    $countsPerMarque[] = $row['count'];
}


// Query to count the number of records per month
$result4 = $repository->getCountByMonth();

// Store data in arrays
$months = array();
$countsPerMonth = array();

foreach ($result4 as $row) {
    $months[] = $row['month'];
    $countsPerMonth[] = $row['count'];
}


// Query to count the number of records per year and month
$result5 = $repository->getCountByYearMonth();

// Store data in arrays
$yearMonths = array();
$countsPerYearMonth = array();

foreach ($result5 as $row) {
    $yearMonths[] = $row['year'] . ' ' . $row['month'];
    $countsPerYearMonth[] = $row['count'];
}

          
        
$totalAnnoncement=$repository->countTotalAnnoncement();
        return $this->render('chartjs/index.html.twig', [
            'years' => $years,
             'countsPerYear' =>$countsPerYear,
             'voitures'=>$voitures,
             'countsPerVoiture'=>$countsPerVoiture,
             'marques'=>$marques,
             'countsPerMarque'=>$countsPerMarque,
             'months' => $months,
             'countsPerMonth'=>$countsPerMonth,
             'yearMonths'=>$yearMonths,
             'countsPerYearMonth'=>$countsPerYearMonth,
             'totalAnnoncement'=>$totalAnnoncement,
        ]);
    }
}
