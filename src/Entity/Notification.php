<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column]
    private $etat;

    #[ORM\Column]
    private $contenu;

    #[ORM\Column]
    private ?\DateTime $envoyerAt ;

  
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

    public function getEtat(): ?bool
    {
        return $this->etat;
    }
    public function getEnvoyerAt(): ?\DateTime
    {
        return $this->envoyerAt;
    }
    public function getIdutilisateur(): ?Utilisateur
    {
        return $this->idutilisateur;
    }

    public function getIdentreprise(): ?EntreprisePartenaire
    {
        return $this->identreprise;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }
    public function setEnvoyerAt( \DateTime $envoyerAt): self
    {
        $this->envoyerAt = $envoyerAt;

        return $this;
    }
    public function setIdutilisateur(Utilisateur $idutilisateur): self
    {
        $this->idutilisateur = $idutilisateur;

        return $this;
    }

    public function setIdentreprise(EntreprisePartenaire $identreprise): self
    {
        $this->identreprise = $identreprise;

        return $this;
    }

}
