<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AccidentRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AccidentRepository::class)]
class Accident
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("accidents")]
    private $id;

    #[ORM\Column]
    #[Assert\NotBlank(message:"le type est requis")]
    #[Groups("accidents")]
    private $type;

    #[ORM\Column]
    #[Groups("accidents")]
    private ?\DateTime $date ;

    
    #[ORM\Column(length:65535)]
    #[Assert\NotBlank(message:"description est requis")]
    #[Assert\Length( 
        min: 10,
        max: 2555,
    minMessage: 'il faut etre superieure au :  {{ limit }} caractéres',
    maxMessage: 'il faut etre inferieur au :  {{ limit }} caractéres')]
    #[Groups("accidents")]
    private $description;

    #[ORM\Column(length:40)]
    #[Assert\NotBlank(message:"lieu est requis")]
    #[Groups("accidents")]
    private $lieu;

   
    #[ORM\ManyToOne(targetEntity: Voiture::class)]
    #[ORM\JoinColumn(name: 'id_voiture', referencedColumnName: 'id')]
    #[Groups("accidents")]
    private $idVoiture;

    public function getId(): ?string
    {
        return $this->id;
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

    

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

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


}
