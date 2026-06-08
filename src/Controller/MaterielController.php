<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Entity\Materiel;
use App\Form\MaterielType;
use App\Form\UpdateMaterielType;
use App\Repository\MaterielRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MaterielController extends AbstractController
{
    #[Route('/materiel', name: 'app_materiel')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repg = $doctrine->getRepository(Garage::class);
        $repm=$doctrine->getRepository(Materiel::class);

        $materiels=$repm->findAll();
        $garages=$repg->findAll();
        return $this->render('materiel/index.html.twig', [
           'garages'=>$garages,
           'materiels'=>$materiels
        ]);
    }

    #[Route('/materielmobile', name: 'app_materiel_mobile')]
    public function indexMobile(ManagerRegistry $doctrine , SerializerInterface $serializer): Response
    {
        $repm=$doctrine->getRepository(Materiel::class);

        $materiels=$repm->findAll();

        $json = $serializer->serialize($materiels , 'json');

        return new Response($json);
    }


    #[Route('/addMateriel/{id}', name:'materiel_g')]
    public function goToMateriel($id , ManagerRegistry $mngr , Request $req ){

        $materiel = new Materiel();
        $garage = $mngr->getRepository(Garage::class)->find($id);

        $em=$mngr->getManager();

        $rep=$mngr->getRepository(Materiel::class);

        $materiels=$rep->getMaterielWithGarageId($id);

        $form=$this->createForm(MaterielType::class,$materiel);

        
        $form->handleRequest($req);



        if( $form->isSubmitted() && $form->isValid()){

            $materiel->setIdGarage($garage);
            $materiel->setDisponibilite(true);

            $em->persist($materiel);

            $em->flush();
            return  $this->redirectToRoute('materiel_g',['id' => $id]);
        
        }

        return $this->render('materiel/addMateriel.html.twig', [
         'form' => $form->createView(),
         'garage'=>$garage,
         'materiels'=>$materiels
        ]);

    }



    
    #[Route('/addMaterielmobile/{id}', name:'materiel_g_mobile')]
    public function goToMaterielMobile($id , ManagerRegistry $mngr , Request $req , SerializerInterface $serializer ){

        $materiel = new Materiel();
        $garage = $mngr->getRepository(Garage::class)->find($id);

        $em=$mngr->getManager();

            $materiel->setIdGarage($garage);
            $materiel->setDisponibilite(true);
            $materiel->setDescription($req->get('description'));
            $materiel->setNom($req->get('nom'));
            $materiel->setPhoto($req->get('photo'));

            $em->persist($materiel);

            $em->flush();
        
            $json = $serializer->serialize($materiel,'json');

        return new Response(200);

    }
    
    #[Route('/deleteMateriel/{id}', name:'app_deleteM')]
    public function deletMateriel($id , ManagerRegistry $doctrine)
    {

        $em=$doctrine->getManager();

        $materiel=$doctrine->getRepository(Materiel::class)->find($id);

        $em->remove($materiel);

        $em->flush();

        return  $this->redirectToRoute('app_materiel');

    }


    #[Route('/deleteMaterielmobile', name:'app_deleteM_mobile')]
    public function deletMaterielMobile(Request $req , ManagerRegistry $doctrine)
    {

        $em=$doctrine->getManager();

        $materiel=$doctrine->getRepository(Materiel::class)->find($req->get('id'));

        $em->remove($materiel);

        $em->flush();

        return  new Response(200);

    }

    #[Route('/updateMateriel/{id}', name:'app_updateM')]
    public function updateMateriel($id , ManagerRegistry $doctrine , Request $req)
    {

        $materiel=$doctrine->getRepository(Materiel::class)->find($id);

        $form=$this->createForm(UpdateMaterielType::class,$materiel);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_materiel');
        }

        return $this->render('materiel/updateMateriel.html.twig',[
            'form'=>$form->createView(),
            'm'=>$materiel
        ]);

    }



    #[Route('/updateMaterielmobile/{id}', name:'app_updateM_mobile')]
    public function updateMaterielMobile($id , ManagerRegistry $doctrine , Request $req , SerializerInterface $serializer)
    {

        $materiel=$doctrine->getRepository(Materiel::class)->find($id);

        $garage=$doctrine->getRepository(Garage::class)->find($req->get('idgarage'));
        $materiel->setIdGarage($garage);
        $materiel->setDisponibilite(true);
        $materiel->setDescription($req->get('description'));
        $materiel->setNom($req->get('nom'));
        $materiel->setPhoto($req->get('photo'));


            $em=$doctrine->getManager();
            $em->flush();


        $json=$serializer->serialize($materiel,'json');

        return new Response($json);

    }

    #[Route('/getOnemobile/{id}', name:'app_getone_mobile')]
    public function getOneByid($id , MaterielRepository $repo , SerializerInterface $serial){

        $materiel = $repo->find($id);

        $json = $serial->serialize($materiel,'json');

        return new Response($json);

    }



}
