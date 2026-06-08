<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationRepository;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(length:255)]
    private $pointDepart;

    #[ORM\Column(length:255)]
    private $destination;

    #[ORM\Column]
    private $idClient;

    #[ORM\Column]
    private $idVehicule;

    #[ORM\Column(length:255)]
    private $tempsDepart;

    #[ORM\Column(length:255)]
    private $distance;

    #[ORM\Column(length:255)]
    private $typeTransport;

    #[ORM\Column]
    private $prix;

    #[ORM\Column]
    private $past;


}
