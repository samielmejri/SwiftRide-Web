<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Twilio\Rest\Client;



class SmsTelController extends AbstractController
{
   
    // rest of the controller code
    #[Route('/appsms', name: 'app_sms', methods: ['POST','GET'])]
    public function sendSMS(Request $request, SecurityController $security)
{
    $toPhoneNumber = $request->request->get('toPhoneNumber');
    $user = $security->getUser();
    $username = $user->getName(); // Récupère le nom d'utilisateur à partir de la session

    $sid = 'ACf655a573ed06adb9dd364de8423c9299';
    $token = '364748e6728a6aeda1f8040ab264f0cc';
    $client = new Client($sid, $token);
    $message = $client->messages->create(
        "+216".$toPhoneNumber,
        [
            'from' => '+16203509330', 
            'body' => 'La réservation du Client ' . $username . ' a été effectué avec succés ',
        ]
    );
  
    //$em->flush();
    return $this->redirectToRoute('app_reservation_m', [], Response::HTTP_SEE_OTHER);

}
}