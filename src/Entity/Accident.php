<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AccidentRepository;

#[ORM\Entity(repositoryClass: AccidentRepository::class)]
class Accident
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column]
    private $type;

    #[ORM\Column]
    private $date = 'CURRENT_TIMESTAMP';

    
    #[ORM\Column(length:65535)]
    private $description;

    #[ORM\Column(length:40)]
    private $lieu;

   
    #[ORM\ManyToOne(targetEntity: Voiture::class)]
    #[ORM\JoinColumn(name: 'id_voiture', referencedColumnName: 'id')]
    private $idVoiture;


}
