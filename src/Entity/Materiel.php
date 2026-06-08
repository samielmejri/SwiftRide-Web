<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MaterielRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
class Materiel
{
  
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(length:11)]
    #[Assert\NotBlank(message:"l'intitule est requis")]
    #[Assert\Length( 
        min: 3,
        max: 255,
    minMessage: 'il faut etre superieure au :  {{ limit }} caractéres',
    maxMessage: 'il faut etre inferieur au :  {{ limit }} caractéres')]
    private $nom;

    #[ORM\Column(length:255)]
    #[Assert\NotBlank(message:"la reference est requis")]
    #[Assert\Length( 
        min: 3,
        max: 255,
    minMessage: 'il faut etre superieure au :  {{ limit }} caractéres',
    maxMessage: 'il faut etre inferieur au :  {{ limit }} caractéres')]
    private $photo;

    #[ORM\Column(length:255)]
    #[Assert\NotBlank(message:"la description est requis")]
    #[Assert\Length( 
        min: 3,
        max: 255,
    minMessage: 'il faut etre superieure au :  {{ limit }} caractéres',
    maxMessage: 'il faut etre inferieur au :  {{ limit }} caractéres')]
    private $description;

    #[ORM\Column] 
    private $disponibilite;

    #[ORM\ManyToOne(targetEntity: Garage::class)]
    #[ORM\JoinColumn(name: 'id_garage', referencedColumnName: 'id')]
    private ?Garage $idGarage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(?bool $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

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



}
