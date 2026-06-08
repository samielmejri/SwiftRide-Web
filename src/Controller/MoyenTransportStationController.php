<?php

namespace App\Controller;

use App\Entity\MoyenTransport;
use App\Entity\Station;
use App\Form\MoyenTransportStationType;
use App\Repository\MoyenTransportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoyenTransportStationController extends AbstractController
{
    /**
     * @Route("/moyentransportstation", name="moyen_transport_station")
     */
    public function index(Request $request, MoyenTransportRepository $moyenTransportRepository): Response
    {
        $moyenTransportStationForm = $this->createForm(MoyenTransportStationType::class);
        $moyenTransportStationForm->handleRequest($request);

        if ($moyenTransportStationForm->isSubmitted() && $moyenTransportStationForm->isValid()) {
            // Get data from form
            $data = $moyenTransportStationForm->getData();

            // Get the moyen transport and the station from the data
            $moyenTransport = $data['moyenTransport'];
            $station = $data['station'];

            // Add the station to the moyen transport
            $moyenTransport->addStation($station);

            // Save the changes to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($moyenTransport);
            $entityManager->flush();

            $this->addFlash('success', 'La station a été ajoutée au moyen de transport.');

            return $this->redirectToRoute('moyen_transport_station');
        }

        $moyenTransports = $moyenTransportRepository->findAll();

        return $this->render('moyen_transport_station/index.html.twig', [
            'moyenTransports' => $moyenTransports,
            'moyenTransportStationForm' => $moyenTransportStationForm->createView(),
        ]);
    }
}
