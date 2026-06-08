<?php

namespace App\Controller;

use App\Form\MoyenTransportType;
use App\Entity\MoyenTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MoyenTransportRepository;


class MoyenTransportController extends AbstractController 
{

    #[Route('/moyentransport', name: 'app_moyentransport')]
    public function index(): Response
    {
        $MoyenTransport = $this->getDoctrine()->getManager()->getRepository(MoyenTransport::class)->findAll();
        $form = $this->createForm(MoyenTransportType::class);
        return $this->render('moyen_transport/index.html.twig', [
            't'=>$MoyenTransport

        ]);
       
    }
   
    /**
     * @Route("/addmoyentransport", name="addMoyenTransport")
     */

    public function addMoyenTransport(Request $request): Response
    {
        $MoyenTransport = new MoyenTransport();
        $form = $this->createForm(MoyenTransportType::class, $MoyenTransport);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($MoyenTransport);//Add
            $em->flush();

            return $this->redirectToRoute('app_moyentransport');
        }
        return $this->render('moyen_transport/createMoyenTransport.html.twig',['f'=>$form->createView()]);



    }

    #[Route('/removeMoyenTransport/{id}', name: 'supmoyentransport')]
    public function suppressionMoyenTransport(MoyenTransport $MoyenTransport): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($MoyenTransport);
        $em->flush();
        
        
        //return$this->redirectToRoute('supmoyentransport');
        return $this->redirectToRoute('app_moyentransport', ['id' => $MoyenTransport->getId()]);


    }


    #[Route('/modifmoyentransport/{id}', name: 'modifMoyenTransport')]
     public function modifMoyenTransport(Request $request,$id): Response
     {
         $MoyenTransport = $this->getDoctrine()->getManager()->getRepository(MoyenTransport::class)->find($id);
         $form = $this->createForm(MoyenTransportType::class, $MoyenTransport);
 
         $form->handleRequest($request);
 
         if($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->flush();
 
             return $this->redirectToRoute('app_moyentransport');
         }
         return $this->render('moyen_transport/updateMoyenTransport.html.twig',['f'=>$form->createView()]);
 
     }
   


}