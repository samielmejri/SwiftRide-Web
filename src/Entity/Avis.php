<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AvisRepository;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(length:255)]
    private $commentaire;

    #[ORM\Column]
    private $etoile;

    
    #[ORM\ManyToOne(targetEntity: Voiture::class)]
    #[ORM\JoinColumn(name: 'id_voiture', referencedColumnName: 'id')]
    private $idVoiture;

    
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id_client', referencedColumnName: 'id')]
    private $idClient;


}
