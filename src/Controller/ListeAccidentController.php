<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Accident;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Voiture;
use App\Form\AccidentType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;

class ListeAccidentController extends AbstractController
{
    #[Route('/listeaccident', name: 'app_liste_accident')]
  
    public function listeaccident(ManagerRegistry $doctrine,PaginatorInterface $paginator, Request $request ): Response
    {
        $accidents =$doctrine->getRepository(Accident::class)->findAll();
        $voitures =$doctrine->getRepository(Voiture::class)->findAll();
        $query =$doctrine->getRepository(Accident::class)->findAll();
        
        
        $accidentsQuery = $doctrine->getRepository(Accident::class)->findAll();
        $accidentpager = $paginator->paginate(
            $accidentsQuery,
            $request->query->getInt('page', 1),
            5 // number of items per page
        );


        return $this->render('gestion_accident/ListeAccident.html.twig', [
            'list' => $accidents,
            'accidentpager' => $accidentpager,

        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(ManagerRegistry $doctrine ,$id){
       
        $accidentidenity = $doctrine->getRepository(Accident::class)->find($id);
    
        $em=$doctrine->getManager();
        $em->remove($accidentidenity); 
        $em->flush();
        $this->addFlash('notice','succcefully deleted');
        return $this->redirectToRoute('app_homeadmin');
    }

    #[Route('/deleteJSON/{id}', name: 'deleteJSON')]
    public function deleteJSON(ManagerRegistry $doctrine ,$id,SerializerInterface $serializer){
       
        $accidentidenity = $doctrine->getRepository(Accident::class)->find($id);
    
        $em=$doctrine->getManager();
        $em->remove($accidentidenity); 
        $em->flush();

        $json=$serializer->serialize($accidentidenity,'json',['groups'=>"accidents"]);


        return new Response("Accident deleted successfully" . $json);
        
    }
    
    
    #[Route('/listeaccidentJSON', name: 'listeaccident')]
  
    public function listeaccidentJSON(ManagerRegistry $doctrine,SerializerInterface $serializer )
    {
        $accidents =$doctrine->getRepository(Accident::class)->findAll();
        

        $json=$serializer->serialize($accidents,'json',['groups'=>"accidents"]);


        return new Response($json);
    
    



}
#[Route('/accidentJSON/{id}', name: 'accident')]
  
public function accidentJSONid($id,ManagerRegistry $doctrine,SerializerInterface $serializer )
{
    $accident =$doctrine->getRepository(Accident::class)->find($id);
    

    $json=$serializer->serialize($accident,'json',['groups'=>"accidents"]);


    return new Response($json);





}
}