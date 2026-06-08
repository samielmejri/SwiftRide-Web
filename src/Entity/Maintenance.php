<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MaintenanceRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MaintenanceRepository::class)]
class Maintenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

   
    #[ORM\Column]
    private ?\DateTime $dateMaintenance ;


    #[ORM\Column(length:25)]
    private $type;

    
    #[ORM\Column]
    private ?\DateTime $finMaintenance;

    
    #[ORM\ManyToOne(targetEntity: Garage::class)]
    #[ORM\JoinColumn(name: 'id_garage', referencedColumnName: 'id')]
    private $idGarage;

    
    #[ORM\ManyToOne(targetEntity: Voiture::class)]
    #[ORM\JoinColumn(name: 'id_voiture', referencedColumnName: 'id')]
    private $idVoiture;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'idutilisateur', referencedColumnName: 'id')]
    private $idutilisateur;

     #[ORM\ManyToOne(targetEntity: EntreprisePartenaire::class)]
     #[ORM\JoinColumn(name: 'identreprise', referencedColumnName: 'id')]
    private $identreprise;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMaintenance(): ?\DateTime
    {
        return $this->dateMaintenance;
    }

    public function setDateMaintenance(\DateTime $dateMaintenance): self
    {
        $this->dateMaintenance = $dateMaintenance;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFinMaintenance(): ?\DateTime
    {
        return $this->finMaintenance;
    }

    public function setFinMaintenance(\DateTime $finMaintenance): self
    {
        $this->finMaintenance = $finMaintenance;

        return $this;
    }

    public function getIdGarage(): ?Garage
    {
        return $this->idGarage;
    }

    public function setIdGarage(?Garage $idGarage): self
    {
        $this->idGarage = $idGarage;

        return $this;
    }

    public function getIdVoiture(): ?Voiture
    {
        return $this->idVoiture;
    }

    public function setIdVoiture(?Voiture $idVoiture): self
    {
        $this->idVoiture = $idVoiture;

        return $this;
    }


    public function getIdutilisateur() : ?Utilisateur
    {
        return $this->idutilisateur;
    }

    public function setIdutilisateur(?Utilisateur $idutilisateur): self
    {
        $this->idutilisateur = $idutilisateur;

        return $this;
    }

    public function getIdentreprise() : ?EntreprisePartenaire
    {
        return $this->identreprise;
    }

    public function setIdentreprise(?EntreprisePartenaire $identreprise): self
    {
        $this->identreprise = $identreprise;

        return $this;
    }



}
