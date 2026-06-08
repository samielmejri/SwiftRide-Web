<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Entity\Materiel;
use App\Form\GarageType;
use App\Form\MaterielType;
use App\Repository\GarageRepository;
use Doctrine\Persistence\ManagerRegistry;
use SebastianBergmann\Environment\Console;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GarageController extends AbstractController
{
    #[Route('/garage', name: 'app_garage')]
    public function index(ManagerRegistry $doctrine , Request $req): Response
    {
        $em=$doctrine->getManager();
        $garage = new Garage();

        $form = $this->createForm(GarageType::class , $garage);
        $forms = $this->createForm(GarageType::class);
        
        $form->handleRequest($req);

        $garages=$doctrine->getRepository(Garage::class)->findAll();

        if($form->isSubmitted() && $form->isValid()){

            $doctrine->getRepository(Garage::class)->save($garage,true);

            return  $this->redirectToRoute('materiel_g',['id'=>$garage->getId()]);
        }
        return $this->render('garage/index.html.twig', [
            'form' => $form->createView(),
            'forms' => $forms->createView(),
            'garages'=>$garages
        ]);
    }


    #[Route('/garagemobile', name: 'app_garage_mobile', methods:'post')]
    public function indexMobile(ManagerRegistry $doctrine , Request $req , SerializerInterface $serializer): Response
    {
        $em=$doctrine->getManager();
        $garage = new Garage();

        $garage->setMatriculeGarage($req->get('matriculeGarage'));
        $garage->setLocalisation($req->get('localisation'));
        $garage->setSurface($req->get('surface'));

        $em->persist($garage);
        $em->flush();

            $json=$serializer->serialize($garage,'json');

        return new Response($json);
    }


    #[Route('/deleteGarage/{id}', name:'app_deleteg')]
    public function deleteGarage($id , ManagerRegistry $mngr){

        $garage = $mngr->getRepository(Garage::class)->find($id);

        $em=$mngr->getManager();

        $em->remove($garage);

        $em->flush();

        return $this->redirectToRoute('app_garage');

    }

    #[Route('/deleteGaragemobile', name:'app_deleteg_mobile')]
    public function deleteGarageMobile( Request $req  , ManagerRegistry $mngr){

        $garage = $mngr->getRepository(Garage::class)->find($req->get('id'));

        $em=$mngr->getManager();

        $em->remove($garage);

        $em->flush();


        return new Response(200);

    }

   #[Route('/updateGarage/{id}', name:'app_updateg')]
    public function udpateGarage($id , ManagerRegistry $mngr , Request $req) : Response
    {
        $garage = $mngr->getRepository(Garage::class)->find($id);

        $form=$this->createForm(GarageType::class,$garage);
        $form->handleRequest($req);


        if($form->isSubmitted() && $form->isValid()){
            $em = $mngr->getManager();
            $em->flush();

            return $this->redirectToRoute('app_garage');
        }

        return $this->render('garage/updateGarage.html.twig', [
            'form' => $form->createView(),
            'g'=>$garage
        ]);
       
    }


    #[Route('/updateGaragemobile/{id}', name:'app_updateg_mobile')]
    public function udpateGarageMobile($id , ManagerRegistry $mngr , Request $req , SerializerInterface $serialize) : Response
    {
        $garage = $mngr->getRepository(Garage::class)->find($id);

        $garage->setMatriculeGarage($req->get('matricule'));
        $garage->setLocalisation($req->get('localisation'));
        $garage->setSurface($req->get('surface'));

            $em = $mngr->getManager();
            $em->flush();

       $json= $serialize->serialize($garage,'json');

        return new Response($json);
       
    }

    #[Route('/garageMobileList', name:'app_garage_list_mobile')]
    public function listGarageMobile(GarageRepository $rep , SerializerInterface $serialize){

        $garages=$rep->findAll();

        $json=$serialize->serialize($garages,'json');

        return new Response($json);
        
    }


}
