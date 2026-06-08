<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GarageRepository;

use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: GarageRepository::class)]
class Garage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;
 
    #[ORM\Column(length:40)]
    #[Assert\NotBlank(message:"Matricule est requis")]
    #[Assert\Length( 
        min: 3,
        max: 255,
    minMessage: 'il faut etre superieure au :  {{ limit }} caractéres',
    maxMessage: 'il faut etre inferieur au :  {{ limit }} caractéres')]
    private $matriculeGarage;

    #[ORM\Column]
    #[Assert\NotBlank(message:"la surface est requis")]
    #[Assert\Positive(message: 'le valeur doit etre positif')]
    #[Assert\Range(
        min: 100,
        max: 1000,
        notInRangeMessage: 'le valeur doit etre entre {{ min }} et  {{ max }}'
    )]
    #[Assert\Type(
        type: 'integer',
        message: 'doit erte seulement des chiffres'
    )]
    private $surface;

    #[ORM\Column(length:150)]
    #[Assert\NotBlank(message:"la localisation est requis")]
    #[Assert\Length( 
        min: 8,
    minMessage: 'le matricule doit etre superieure au :  {{ limit }} caractéres')]
    private $localisation;

     /* #[ORM\OneToMany(mappedBy: 'idGarage', targetEntity: Materiel::class)]
    private Collection  $materiels;*/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatriculeGarage(): ?string
    {
        return $this->matriculeGarage;
    }

    public function setMatriculeGarage(string $matriculeGarage): self
    {
        $this->matriculeGarage = $matriculeGarage;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(?int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }
/*
    /**
     * @return Collection<int, Student>
     */
 /*   public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    public function addStudent(Materiel $materiel): self
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels->add($materiel);
            $materiel->setIdGarage($this);
        }

        return $this;
    }

    public function removeStudent(Materiel $materiels): self
    {
        if ($this->materiels->removeElement($materiels)) {
            // set the owning side to null (unless already changed)
            if ($materiels->getIdGarage() === $this) {
                $materiels->setIdGarage(null);
            }
        }

        return $this;
    }*/


}
