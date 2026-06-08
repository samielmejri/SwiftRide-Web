<?php

namespace App\Controller;

use App\Repository\ReservationMRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ReservationM;
use App\Form\ReservationMType;
use App\Service\PdfService;

class ReservationMController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation_m')]
    public function index(ReservationMRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        return $this->render('reservation_m/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/pdf', name: 'pdf_reservation')]
    public function generatePdfReservationList(ReservationMRepository $reservationMRepository, PdfService $pdf): Response
    {
        // Récupérer toutes les réservations
        $reservations = $reservationMRepository->findAll();
        // Passer les réservations au template pour les afficher
        $html = $this->render('reservation_m/index2.html.twig', ['reservations' => $reservations]);
        // Générer le PDF à partir de la table HTML
        $pdfContent = $pdf->generatePdfFile($html);
        // Retourner une réponse avec le contenu du PDF pour le téléchargement
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="reservation_list.pdf"'
        ]);
    }
    


    


     /**
     * @Route("/addreservation", name="addReservation")
     */

     public function addReservation(Request $request): Response
     {
         $ReservationM = new ReservationM();
         $form = $this->createForm(ReservationMType::class, $ReservationM);
 
         $form->handleRequest($request);
 
         if($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->persist($ReservationM);//Add
             $em->flush();
 
             return $this->redirectToRoute('app_reservation_m');
         }
         return $this->render('reservation_m/createReservationM.html.twig',['form'=>$form->createView()]);
 
     }
}