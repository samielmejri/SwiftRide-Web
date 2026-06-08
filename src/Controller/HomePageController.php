<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\Voiture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class HomePageController extends AbstractController
{
    #[Route('/homepage', name: 'app_home_page')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $annonce =$doctrine->getRepository(Annonces::class)->findAll();
        
        
        return $this->render('home_page/index.html.twig', [
            'list' => $annonce,
       
        ]);
    }
    #[Route('/homepage/annonces', name: 'app_home_page_annonces')]
    public function list(ManagerRegistry $doctrine): Response
{
    $annonce =$doctrine->getRepository(Annonces::class)->findAll();
    $voiture =$doctrine->getRepository(Voiture::class)->findAll();
    return $this->render('home_page/annonces.html.twig', [
        'list' => $annonce,
        'list'=>  $voiture,
    ]);
}
}
