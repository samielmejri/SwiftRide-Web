<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VoitureRepository;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(length:255)]
    private $cartegrise;

    #[ORM\Column(length:40)]
    private $marque;

    #[ORM\Column(length:40)]
    private $model;

    #[ORM\Column(length:20)]
    private $etat;

    #[ORM\Column(length:20)]
    private $couleur;

    #[ORM\Column(length:25)]
    private $etatTechnique;

    #[ORM\Column(length:50)]
    private $matricule;

    #[ORM\Column]
    private $dateCirculation;

    #[ORM\Column]
    private $prix;

    #[ORM\Column]
    private $kilometrage;

    #[ORM\Column(length:150)]
    private $image;

    #[ORM\Column(length:255)]
    private $position;

    
    #[ORM\ManyToOne(targetEntity: EntreprisePartenaire::class)]
    #[ORM\JoinColumn(name: 'id_entreprise_partenaire', referencedColumnName: 'id')]
    private $idEntreprisePartenaire;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id')]
    private $idUtilisateur;


    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }
    public function getModel(): ?string
    {
        return $this->model;
    }
    
    public function getDateCirculation(): ?string
    {
        return $this->dateCirculation;
    }

    public function getKilometrage(): ?string
    {
        return $this->kilometrage;
    }

    public function getEtatTechnique(): ?string
    {
        return $this->etatTechnique;
    }
    public function setIdEntreprisePartenaire(?EntreprisePartenaire $idEntreprisePartenaire) :self
    {
        $this->idEntreprisePartenaire = $idEntreprisePartenaire;

        return $this;
    }
    public function getIdEntreprisePartenaire (): ?EntreprisePartenaire
    {
        return $this->idEntreprisePartenaire;
    }

}
