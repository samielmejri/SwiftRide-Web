<?php

namespace App\Controller;

use App\Entity\EntreprisePartenaire;
use App\Entity\Garage;
use App\Entity\Maintenance;
use App\Entity\Notification;
use App\Entity\Utilisateur;
use App\Entity\Voiture;
use App\EventSubscriber\PdfService;
use App\Form\MaintenanceType;
use App\Form\RendezVousType;
use App\Form\SuiteRendezVousType;
use App\Repository\MaintenanceRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class MaintenanceController extends AbstractController
{
    #[Route('/maintenance', name: 'app_maintenance')]
    public function index(ManagerRegistry $doctrine ): Response
    {
        $maintenances = $doctrine->getRepository(Maintenance::class)->findAll();

        return $this->render('maintenance/index.html.twig', [
            'maintenances'=>$maintenances
        ]);
    }

    #[Route('/maintenancemobile', name: 'app_maintenance')]
    public function indexMobile(ManagerRegistry $doctrine , SerializerInterface $serializer): Response
    {
        $maintenances = $doctrine->getRepository(Maintenance::class)->findAll();

        $json=$serializer->serialize($maintenances , 'json');

        return new Response($json);
    }


    #[Route('/deleteMaintenence/{id}', name: 'delete_maintenance')]
    public function deleteMaintenance($id,ManagerRegistry $doctrine)
    {

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);
        

        $em=$doctrine->getManager();

        $em->remove($maintenance);

        $em->flush();

        return $this->redirectToRoute('app_maintenance');
    }

    #[Route('/deleteMaintenencemobile', name: 'delete_maintenance')]
    public function deleteMaintenanceMoble(Request $req,ManagerRegistry $doctrine  , SerializerInterface $serializer)
    {

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($req->get('id'));
        

        $em=$doctrine->getManager();

        $em->remove($maintenance);

        $em->flush();

        return new Response(200);
    }
    
    #[Route('/deleteMaintenences/{id}', name: 'delete_maintenance_notif')]
    public function deleteMaintenanceWithNOtif($id,ManagerRegistry $doctrine)
    {

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);
        

        $em=$doctrine->getManager();

        $em->remove($maintenance);

        $em->flush();

        return $this->redirectToRoute('app_maintenance');
    }

    #[Route('/SupprimerMaintenace/{id}', name: 'supp_maint' , methods:'post')]
    public function deleteMaintenanceClient($id,ManagerRegistry $doctrine)
    {

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);
       $notification = new Notification(); 

        $em=$doctrine->getManager();

        $em->remove($maintenance);

        $em->flush();

        $notification->setEtat(false);
        $notification->setContenu("Pour des raison administratif Votre Rendez-vous qui a été planifier le : ".
    $maintenance->getDateMaintenance() ."pour votre " );
        $notification->setEnvoyerAt(new DateTime());
        $notification->setIdentreprise($doctrine->getRepository(EntreprisePartenaire::class)->find(1));
        $doctrine->getRepository(Notification::class)->save($notification,true);

        return $this->redirectToRoute('histo_client');
    }

    #[Route('/updateMaintenance/{id}', name: 'update_maintenance')]
    public function updateMaintenance($id , ManagerRegistry $doctrine , Request $req)
    {

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);
        
        $garages=$doctrine->getRepository(Garage::class)->findAll();

        $form=$this->createForm(MaintenanceType::class,$maintenance, [
            'myEntities' => $garages,
        ]);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){

            $datesrc= $form->get('dateMaintenance')->getData();
            $date = new \DateTime($datesrc->format('Y-m-d H:i:s'));

            $maintenance->setFinMaintenance($date->modify('+2 hours'));

            $em = $doctrine->getManager();
            $em->flush();

            return $this->redirectToRoute('app_maintenance');

        }

        return $this->render('maintenance/updateMaintenance.html.twig', [
            'form'=>$form->createView(),
            'm'=>$maintenance
        ]);

    }

    #[Route('/partenairecars/{id}', name: 'cars_maintenance')]
    public function dataTable(ManagerRegistry $doctrine , $id){

        $partenaire = $doctrine->getRepository(Voiture::class)->find($id);

        $cars= $doctrine->getRepository(Voiture::class)->getCarsWithPartnerId($id);

        return $this->render('maintenance/voiturePourLesmaintenace.html.twig', [
            'voitures'=>$cars,
            'partenaire'=>$partenaire
        ]);

    }

    #[Route('/rendez-vous/{id}', name: 'rendez_vous')]
    public function passerRendezVous(Request $req , ManagerRegistry $doctrine , $id){

        $voiture=$doctrine->getRepository(Voiture::class)->find($id);

        $garages=$doctrine->getRepository(Garage::class)->findAll();

       // $maintenance = new Maintenance();

        $form= $this->createForm(RendezVousType::class,null,[
            'myEntities' => $garages,
        ]);

        $form->handleRequest($req);


       
        if($form->isSubmitted() && $form->isValid())
        {


            $datesrc= $form->get('dateMaintenance')->getData();
            $date = new \DateTime($datesrc->format('Y/m/d'));

            $garage=$form->get('idGarage')->getData();

            $idg=$garage->getId();
            $idv =$voiture->getId();

            $datev=$date->format('Y-m-d');
            
          

            return $this->redirectToRoute('finale_etape',['id'=>$idv,'d'=>$datev , 'idg'=>$idg]);
        }

        return $this->render('maintenance/rendez-vousMaintenance.html.twig', [
            'form'=>$form->createView(),
            'v'=>$voiture
        ]);

    }

    #[Route('/rendez-vous1/{id}/{d}/{idg}', name: 'finale_etape')]
    public function rendezVous(ManagerRegistry $doctrine , Request $req  , $id , $idg , $d){

        $voiture=$doctrine->getRepository(Voiture::class)->find($id);

        $garage=$doctrine->getRepository(Garage::class)->find($idg);

        $time=[];

        $maintenances=$doctrine->getRepository(Maintenance::class)->getMaitenanceWithGarageAndDate($idg,$d);

        $maintenancess=$doctrine->getRepository(Maintenance::class)->findAll();

        $tabmain=[];

        $carIsFound=false;

        $showMsg=false;

        $dateCarFourd = new DateTime();

        $now = new DateTime($d);

        $errorMsg="";

        
        foreach($maintenancess as $m){

            if($m->getIdVoiture()->getId()==$id){
                $carIsFound=true;
                $dateCarFourd = new \DateTime($m->getDateMaintenance()->format('Y-m-d H:i:s'));
            }
        }

        foreach($maintenances as $m){
            $tabmain[]=$m->getDateMaintenance()->format('H:i:s');
        }

        
  

        $length = count($maintenances);
        if($length==0){
            array_push($time,"08:00:00","10:30:00","13:00:00","15:30:00");
        }
        else{

            $tabTimes=["08:00:00","10:30:00","13:00:00","15:30:00"];
            

            foreach ($tabTimes as $key => $value) {
                if (in_array($value, $tabmain)) {
                    unset($tabTimes[$key]);
                }
            }

            $time=$tabTimes;
    }
        $form=$this->createForm(SuiteRendezVousType::class ,null,[
            'myEntities' => $time,
        ]);

        $form->handleRequest($req);


        $maintenance = new Maintenance();

        $notification = new Notification();
        
         $em=$doctrine->getManager();

         $diff= $dateCarFourd->diff($now)->days;


         if( $carIsFound && $diff > 21 ){

            $showMsg=false;

        if($form->isSubmitted() && $form->isValid()){

            //concatiner date + heur 
            $t=$form->get('temps')->getData();

            $dateHeure = \DateTime::createFromFormat('Y-m-d H:i:s', $d . ' ' . $t);


            $date = new \DateTime($dateHeure->format('Y-m-d H:i:s'));

            $maintenance->setDateMaintenance($dateHeure);
            $maintenance->setIdGarage($garage);
            $maintenance->setIdVoiture($voiture);
            $maintenance->setType($form->get('type')->getData());
            $maintenance->setFinMaintenance($date->modify('+2 hours'));
            $maintenance->setIdentreprise($doctrine->getRepository(EntreprisePartenaire::class)->find(1));

            $notification->setEtat(false);
            $notification->setContenu("Une maintenance est planifier le : ".$d."de la part de votre partenaire '".
            $doctrine->getRepository(EntreprisePartenaire::class)->find(1)->getNomEntreprise()."'
            a été lieu dans l'un de vos Garage '".$garage->getMatriculeGarage()."' / ".$garage->getLocalisation());
           /* $notification->setContenu("Votre voiture :".$voiture->getMarque()."/".$voiture->getMatricuel().
        "a un Rendez-vous pour un maintenance le : ".$d."a été prise de la part de votre client");*/
            $notification->setEnvoyerAt(new DateTime());
            $notification->setIdentreprise($doctrine->getRepository(EntreprisePartenaire::class)->find(1));
            $doctrine->getRepository(Notification::class)->save($notification,true);

            $em->persist($maintenance); 

            $em->flush(); 

            return $this->redirectToRoute('histo_Entre');
        }


      }
      else if( $carIsFound && $diff < 21) {

        $showMsg=true;

        $errorMsg= ("Votre Voiture : " .$voiture->getMarque()."/".$voiture->getMatricule().
        " doit depasser 21 jour pour prendre un autre Rendez-vous pour une maintenance");
      }
       else{

        $showMsg=false;

        if($form->isSubmitted() && $form->isValid()){

            //concatiner date + heur 
            $t=$form->get('temps')->getData();

            $dateHeure = \DateTime::createFromFormat('Y-m-d H:i:s', $d . ' ' . $t);


            $date = new \DateTime($dateHeure->format('Y-m-d H:i:s'));

            $maintenance->setDateMaintenance($dateHeure);
            $maintenance->setIdGarage($garage);
            $maintenance->setIdVoiture($voiture);
            $maintenance->setType($form->get('type')->getData());
            $maintenance->setFinMaintenance($date->modify('+2 hours'));
            $maintenance->setIdentreprise($doctrine->getRepository(EntreprisePartenaire::class)->find(1));

            $em->persist($maintenance); 
            $em->flush();

            $notification->setEtat(false);
            $notification->setContenu("Une maintenance est planifier le : ".$d."de la part de votre partenaire '".
            $doctrine->getRepository(EntreprisePartenaire::class)->find(1)->getNomEntreprise()."'
            a été lieu dans l'un de vos Garage '".$garage->getMatriculeGarage()."' / ".$garage->getLocalisation());
            $notification->setEnvoyerAt(new DateTime());
            $notification->setIdentreprise($doctrine->getRepository(EntreprisePartenaire::class)->find(1));
            $doctrine->getRepository(Notification::class)->save($notification,true);

          //  $maintenance->setIdentreprise($this->getUser())
           

             

            return $this->redirectToRoute('histo_Entre');
        }

               
            }
        

        return $this->render('maintenance/suiteRende-vous.html.twig', [
            'form'=>$form->createView(),
            'v'=>$voiture,
            'isfound'=>$showMsg,
            "erreur"=>$errorMsg,
            "time"=>$time,
            
        ]);

    
}

    #[Route('/passerRendez-vous/{id}', name: 'client_rv')]
    public function passerRendezVousClient( ManagerRegistry $doctrine , Request $req , $id){


        $voiture=$doctrine->getRepository(Voiture::class)->find($id);
        $garages=$doctrine->getRepository(Garage::class)->findAll();

        $form = $this->createForm(RendezVousType::class , null , ['myEntities' => $garages,]);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid() )
        {


            $datesrc= $form->get('dateMaintenance')->getData();
            $date = new \DateTime($datesrc->format('Y/m/d'));

            $garage=$form->get('idGarage')->getData();

            $idg=$garage->getId();
            $idv =$voiture->getId();

            $datev=$date->format('Y-m-d');
            
          

            return $this->redirectToRoute('final_client',['idv'=>$idv,'da'=>$datev , 'idgr'=>$idg]);
        }


        return $this->render('maintenance/rendez-vouMaintClient.html.twig', [
            'form'=>$form->createView(),
            'v'=>$voiture
        ]);
    }


    
    #[Route('/rendez-vous-client/{idv}/{da}/{idgr}', name: 'final_client')]
    public function rendezVousClient(ManagerRegistry $doctrine , Request $req  , $idv , $idgr , $da){

        $voiture=$doctrine->getRepository(Voiture::class)->find($idv);

        $garage=$doctrine->getRepository(Garage::class)->find($idgr);

        $time=[];

        $maintenances=$doctrine->getRepository(Maintenance::class)->getMaitenanceWithGarageAndDate($idgr,$da);

        $tabmain=[];

        $carIsFound=true;

        $showMsg=false;

        $dateCarFourd = new DateTime();


        $now = new DateTime($da);

        $maintenancess=$doctrine->getRepository(Maintenance::class)->findAll();

        
        foreach($maintenancess as $m){

            if($m->getIdVoiture()->getId()==$voiture->getId()){

                $carIsFound=true;

                $dateCarFourd = new \DateTime($m->getDateMaintenance()->format('Y-m-d H:i:s'));
            }
        }

        $diff= $dateCarFourd->diff($now)->days;

        foreach($maintenances as $m){
            $tabmain[]=$m->getDateMaintenance()->format('H:i:s');
        }

        $length = count($maintenances);

        if($length==0){
            array_push($time,"8:00:00","10:30:00","13:00:00","15:30:00");
        }
        else{
            $tabTimes=["08:00:00","10:30:00","13:00:00","15:30:00"];

            foreach ($tabTimes as $key => $value) {
                if (in_array($value, $tabmain)) {
                    unset($tabTimes[$key]);
                }
            }

            $time=$tabTimes;
}

        $form=$this->createForm(SuiteRendezVousType::class ,null,[
            'myEntities' => $time,
        ]);

        $form->handleRequest($req);


        $maintenance = new Maintenance();

        $notification=new Notification();
        
         $em=$doctrine->getManager();

        

         if( $carIsFound && $diff > 21 ){

        if($form->isSubmitted() && $form->isValid()){

            //concatiner date + heur 
            $t=$form->get('temps')->getData();

            $dateHeure = \DateTime::createFromFormat('Y-m-d H:i:s', $da . ' ' . $t);


            $date = new \DateTime($dateHeure->format('Y-m-d H:i:s'));

            $maintenance->setDateMaintenance($dateHeure);
            $maintenance->setIdGarage($garage);
            $maintenance->setIdVoiture($voiture);
            $maintenance->setType($form->get('type')->getData());
            $maintenance->setFinMaintenance($date->modify('+2 hours'));
            $maintenance->setIdutilisateur($doctrine->getRepository(Utilisateur::class)->find(1));

            $notification->setEtat(false);
            $notification->setContenu("Votre voiture :".$voiture->getMarque()."/".$voiture->getMatricule().
        "a un Rendez-vous pour un maintenance le : ".$da."a été prise de la part de votre client : ".$doctrine->getRepository(Utilisateur::class)->find(1)->getNom());
            $notification->setEnvoyerAt(new DateTime());
            $notification->setIdutilisateur($doctrine->getRepository(Utilisateur::class)->find(1));
            $doctrine->getRepository(Notification::class)->save($notification,true);

            $em->persist($maintenance); 

            $em->flush(); 

            return $this->redirectToRoute('histo_client');

        }

    }
    else if( $carIsFound && $diff < 21) {

        $showMsg=true;
      }
    else{

        $showMsg=false;
        if($form->isSubmitted() && $form->isValid()){

            //concatiner date + heur 
            $t=$form->get('temps')->getData();

            $dateHeure = \DateTime::createFromFormat('Y-m-d H:i:s', $da . ' ' . $t);


            $date = new \DateTime($dateHeure->format('Y-m-d H:i:s'));

            $maintenance->setDateMaintenance($dateHeure);
            $maintenance->setIdGarage($garage);
            $maintenance->setIdVoiture($voiture);
            $maintenance->setType($form->get('type')->getData());
            $maintenance->setFinMaintenance($date->modify('+2 hours'));

            notification->setEtat(false);
            $notification->setContenu("Votre voiture :".$voiture->getMarque()."/".$voiture->getMatricule().
        "a un Rendez-vous pour un maintenance le : ".$da."a été prise de la part de votre client : ".$doctrine->getRepository(Utilisateur::class)->find(1)->getNom());
            $notification->setEnvoyerAt(new DateTime());
            $notification->setIdutilisateur($doctrine->getRepository(Utilisateur::class)->find(1));
            $doctrine->getRepository(Notification::class)->save($notification,true);

            $em->persist($maintenance); 

            $em->flush(); 

            return $this->redirectToRoute('histo_client');

        }
    }

        return $this->render('maintenance/suiteRendez-vousClient.html.twig', [
            'form'=>$form->createView(),
            'v'=>$voiture,
            'time'=>$time,
            'isfound'=>$showMsg,
            "diff"=>$diff
        ]);

    
    }

    #[Route('/calendrier', name: 'app_calender')]
    public function calendrierDesMaintenance(){
        return $this->render('maintenance/calendrierDesMaintenances.html.twig');

    }

    #[Route('/detailMaintenance/{id}', name: 'app_detail_maint')]
    public function detailMaintenance(ManagerRegistry $doctrine , $id){

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);



        return $this->render('maintenance/detailMaintenance.html.twig',[
            "maintenance"=>$maintenance,
        ]);
    }

    #[Route('/detailMaintenanceClient/{id}', name: 'app_detail_maint_client')]
    public function detailMaintenanceClient(ManagerRegistry $doctrine , $id){

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);



        return $this->render('maintenance/detailMaintenanceClient.html.twig',[
            "maintenance"=>$maintenance,
        ]);
    }

    #[Route('/pdf/{id}', name: 'app_pdf')]
    public function pdfFile( $id , ManagerRegistry $doctrine , PdfService $pdf){

        $maintenance=$doctrine->getRepository(Maintenance::class)->find($id);

        $html= $this->renderView('maintenance/pdfDetail.html.twig',[
            "maintenance"=>$maintenance,
        ]);

        $pdf->showPdfFile($html);
        
        return new Response('',200);
    }

    #[Route('/clientMaintHisto', name: 'histo_client')]
    public function historiqueMaintenanceClient(ManagerRegistry $doctrine){

        $id = 1;

        //if($this->getUser()->getRole()->getId()==2 );
        $maint=$doctrine->getRepository(Maintenance::class)->getHistoMaintForClient($id);

        return $this->render('maintenance/histroqueMaintenanceClinet.html.twig',[
            "maintenances"=>$maint
        ]);

    }
    

    #[Route('/historiqueMaintenance', name: 'histo_Entre')]
    public function historiqueMaintenance(ManagerRegistry $doctrine){

        $id = 2; //$this->getUser()->getId();

        //if($this->getUser()->getRole()->getId()!=1 && $this->getUser()->getRole()->getId()!=2 );
        $maint=$doctrine->getRepository(Maintenance::class)->getHistoMaintForEntreprise($id);

        return $this->render('maintenance/histoMaintenance.html.twig',[
            "maintenances"=>$maint
        ]);

    }


    #[Route('/addmaintenancemovile', name: 'app_mobile_maint')]
    public function addMaintenanceMobile(ManagerRegistry $doctrine , Request $req){

        $garage=$doctrine->getRepository(Garage::class)->find($req->get('idGarage'));
        $voiture =$doctrine->getRepository(Voiture::class)->find($req->get('idVoiture'));

        $maintenance = new Maintenance();


        
        $dateHeure = \DateTime::createFromFormat('Y-m-d H:i:s', $req->get('dateMaintenance'));


        $date = new \DateTime($dateHeure->format('Y-m-d H:i:s'));

        $maintenance->setDateMaintenance($dateHeure);
        $maintenance->setFinMaintenance($date->modify('+2 hours'));
        $maintenance->setType($req->get('type'));
        $maintenance->setIdGarage($garage);
        $maintenance->setIdVoiture($voiture);

        $all = $doctrine->getRepository(Maintenance::class)->getMaitenanceWithGarageAndDateCar( $dateHeure , $req->get('idVoiture'));

        $l = count($all);
        if( $l>0){
            return new Response(206);
        }
        else{

            $em = $doctrine->getManager();

            $em->persist($maintenance);

            $em->flush();

            return new Response(200);
        }

    }
    #[Route('/getOneMaint', name: 'app_mobile_get_one')]
    public function getOneMaintMobile(Request $req , MaintenanceRepository $repo , SerializerInterface $ser){

        $maintenance =$repo->find($req->get('id'));

        $json = $ser->serialize($maintenance,'json');

        return new Response($json);

    }

}
