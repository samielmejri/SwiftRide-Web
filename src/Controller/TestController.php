<?php

namespace App\Controller;

use App\Entity\Annonces;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $annonce =$doctrine->getRepository(Annonces::class)->findAll();

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'list' => $annonce,
        ]);
    }
}
