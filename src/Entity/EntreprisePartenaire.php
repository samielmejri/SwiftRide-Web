<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EntreprisePartenaireRepository;

#[ORM\Entity(repositoryClass: EntreprisePartenaireRepository::class)]
class EntreprisePartenaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(length:50)]
    private $nomEntreprise;

    #[ORM\Column(length:50)]
    private $nomAdmin;

    #[ORM\Column(length:50)]
    private $prenomAdmin;


    #[ORM\Column]
    private $nbVoiture;

    #[ORM\Column(length:12)]
    private $tel;

    #[ORM\Column(length:12)]
    private $matricule;

    #[ORM\Column(length:255)]
    private $login;

    #[ORM\Column(length:255)]
    private $mdp;

    
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id_admin', referencedColumnName: 'id')]
    private $idAdmin;

    public function getNomAdmin(): ?string
    {
        return $this->nomAdmin;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }


}
