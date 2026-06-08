<?php

namespace App\Controller;

use App\Form\StationType;
use App\Entity\Station;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StationRepository;

class StationController extends AbstractController
{

    #[Route('/station', name: 'app_station')]
    public function index(): Response
    {
        $Station = $this->getDoctrine()->getManager()->getRepository(Station::class)->findAll();
        $form = $this->createForm(StationType::class);
        return $this->render('station/index.html.twig', [
            's'=>$Station

        ]);
       
    }
   
    /**
     * @Route("/addstation", name="addStation")
     */
      
    public function addStation(Request $request): Response 
     {
    
        $Station = new Station();
        $form = $this->createForm(StationType::class, $Station);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Station);//Add
            $em->flush();

            return $this->redirectToRoute('app_station');
        }
        return $this->render('station/createStation.html.twig',['f'=>$form->createView()]);



    }

    #[Route('/removeStation/{id}', name: 'supstation')]
    public function suppressionStation(Station $Station): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($Station);
        $em->flush();
        
        
        
        return $this->redirectToRoute('app_station', ['id' => $Station->getId()]);


    }


    #[Route('/modifstation/{id}', name: 'modifStation')]
     public function modifStation(Request $request,$id): Response
     {
         $Station = $this->getDoctrine()->getManager()->getRepository(Station::class)->find($id);
         $form = $this->createForm(StationType::class, $Station);
 
         $form->handleRequest($request);
 
         if($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->flush();
 
             return $this->redirectToRoute('app_station');
         }
         return $this->render('station/updateStation.html.twig',['f'=>$form->createView()]);
 
     }

    }