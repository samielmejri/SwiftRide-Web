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

    public function getCartegrise(): ?string
    {
        return $this->cartegrise;
    }

    public function setCartegrise(string $cartegrise): self
    {
        $this->cartegrise = $cartegrise;

        return $this;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getEtatTechnique(): ?string
    {
        return $this->etatTechnique;
    }

    public function setEtatTechnique(string $etatTechnique): self
    {
        $this->etatTechnique = $etatTechnique;

        return $this;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDateCirculation(): ?string
    {
        return $this->dateCirculation;
    }

    public function setDateCirculation(string $dateCirculation): self
    {
        $this->dateCirculation = $dateCirculation;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getKilometrage(): ?string
    {
        return $this->kilometrage;
    }

    public function setKilometrage(string $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getIdEntreprisePartenaire(): ?EntreprisePartenaire
    {
        return $this->idEntreprisePartenaire;
    }

    public function setIdEntreprisePartenaire(?EntreprisePartenaire $idEntreprisePartenaire): self
    {
        $this->idEntreprisePartenaire = $idEntreprisePartenaire;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

}