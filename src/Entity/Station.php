<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Station
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $ville = null;
    
    /**
     * @ORM\Column(name="nom_station", type="string", length=255)
     */
    private ?string $nomStation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getNomStation(): ?string
    {
        return $this->nomStation;
    }

    public function setNomStation(?string $nomStation): self
    {
        $this->nomStation = $nomStation;

        return $this;
    }
}
