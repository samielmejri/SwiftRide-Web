<?php

namespace App\EventSubscriber;

use App\Repository\MaintenanceRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $maintenanceRepo ;
    private $router;
    public function __construct( MaintenanceRepository $maint , UrlGeneratorInterface $router )
    {

        $this->maintenanceRepo=$maint;
        $this->router=$router;
        
    }
    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

       $maintenances = $this->maintenanceRepo->findAll();

       foreach( $maintenances as $m){

        $maintenancesEvents = new Event(
            $m->getType(),
            $m->getDateMaintenance(),
            $m->getFinMaintenance()
        );

        if(strcmp($m->getType(),'reparation')===0){
            $date= new DateTime();
            if($m->getDateMaintenance() < $date){
        $maintenancesEvents->setOptions([
            'backgroundColor' => '#00FF00',
            'borderColor' => 'black',
        ]);
    }
    else{
        $maintenancesEvents->setOptions([
            'backgroundColor' => '#FFFF00',
            'borderColor' => 'black',
        ]);
    }
}
    if(strcmp($m->getType(),'entretient')===0){
        $date= new DateTime();
        if($m->getDateMaintenance() < $date){
    $maintenancesEvents->setOptions([
        'backgroundColor' => '#77b5fe',
        'borderColor' => 'black',
    ]);
}
else{
    $maintenancesEvents->setOptions([
        'backgroundColor' => '#ff7f00 ',
        'borderColor' => 'black',
    ]);
}
    }
    $maintenancesEvents->addOption(
        'url',
        $this->router->generate('app_maintenance')
    );
        $calendar->addEvent($maintenancesEvents);
       }
    }
    }
