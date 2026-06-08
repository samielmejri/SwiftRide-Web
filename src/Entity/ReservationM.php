<?php

namespace App\Entity;

use App\Repository\ReservationMRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationMRepository::class)
 */
class ReservationM
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(length=255)
     */
    private ?string $nom = null;

    /**
     * @ORM\Column(length=255)
     */
    private ?string $email = null;

    /**
     * @ORM\Column(length=255)
     */
    private ?string $depart = null;

    /**
     * @ORM\Column(length=255)
     */
    private ?string $arrive = null;

    /**
     * @ORM\Column(length=255)
     */
    private ?string $typeM = null;
    
    /**
     * @ORM\Column(type=Types::DATETIMETZ_MUTABLE)
     */
    private ?\DateTimeInterface $temps = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $nb_ticket = null;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getArrive(): ?string
    {
        return $this->arrive;
    }

    public function setArrive(string $arrive): self
    {
        $this->arrive = $arrive;

        return $this;
    }

    public function getTypeM(): ?string
    {
        return $this->typeM;
    }

    public function setTypeM(string $typeM): self
    {
        $this->typeM = $typeM;

        return $this;
    }

    public function getTemps(): ?\DateTimeInterface
    {
        return $this->temps;
    }

    public function setTemps(\DateTimeInterface $temps): self
    {
        $this->temps = $temps;

        return $this;
    }

    public function getNbTicket(): ?int
    {
        return $this->nb_ticket;
    }

    public function setNbTicket(int $nb_ticket): self
    {
        $this->nb_ticket = $nb_ticket;

        return $this;
    }
}
