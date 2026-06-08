<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function index(NotificationRepository $repo): Response
    {
        $notifications = $repo->getNotificationForAdmin();

        return $this->render('notification/listNotificationAdmin.html.twig', [
           'notifs'=>$notifications
        ]);
    }


    #[Route('/notificationEntre', name: 'app_notification_Entre')]
    public function Notifications(NotificationRepository $repo): Response
    {
        $notifications = $repo->getNotificationForEntreprise();

        return $this->render('notification/listNotificationClient.html.twig', [
           'notifs'=>$notifications
        ]);
    }
}
