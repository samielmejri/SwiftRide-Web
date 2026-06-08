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

    #[ORM\Column(length:25)]
    private $matricule;

    #[ORM\Column(length:255)]
    private $login;

    #[ORM\Column(length:255)]
    private $mdp;

    
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id_admin', referencedColumnName: 'id')]
    private $idAdmin;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): self
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getNomAdmin(): ?string
    {
        return $this->nomAdmin;
    }

    public function setNomAdmin(string $nomAdmin): self
    {
        $this->nomAdmin = $nomAdmin;

        return $this;
    }

    public function getPrenomAdmin(): ?string
    {
        return $this->prenomAdmin;
    }

    public function setPrenomAdmin(string $prenomAdmin): self
    {
        $this->prenomAdmin = $prenomAdmin;

        return $this;
    }

    public function getNbVoiture(): ?string
    {
        return $this->nbVoiture;
    }

    public function setNbVoiture(string $nbVoiture): self
    {
        $this->nbVoiture = $nbVoiture;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getIdAdmin(): ?Utilisateur
    {
        return $this->idAdmin;
    }

    public function setIdAdmin(?Utilisateur $idAdmin): self
    {
        $this->idAdmin = $idAdmin;

        return $this;
    }


}