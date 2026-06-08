<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @UniqueEntity(fields={"nom_entreprise"}, message="nom d'entreprise existe déja")
 */
class EntreprisePartenaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_entreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_admin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_admin;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_voiture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdp;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_admin;

    public function __construct()
    {
        $this->id_admin = 11212;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nom_entreprise;
    }

    public function setNomEntreprise(string $nom_entreprise): self
    {
        $this->nom_entreprise = $nom_entreprise;

        return $this;
    }

    public function getNomAdmin(): ?string
    {
        return $this->nom_admin;
    }

    public function setNomAdmin(string $nom_admin): self
    {
        $this->nom_admin = $nom_admin;

        return $this;
    }

    public function getPrenomAdmin(): ?string
    {
        return $this->prenom_admin;
    }

    public function setPrenomAdmin(string $prenom_admin): self
    {
        $this->prenom_admin = $prenom_admin;

        return $this;
    }

    public function getNbVoiture(): ?int
    {
        return $this->nb_voiture;
    }

    public function setNbVoiture(int $nb_voiture): self
    {
        $this->nb_voiture = $nb_voiture;

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
        $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);
        $this->mdp = $hashedPassword;
        return $this;
    }

    public function getIdadmin(): ?string
    {
        return $this->id_admin;
    }

    public function setIdadmin(string $id_admin): self
    {
        $this->id_admin = $id_admin;
        return $this;
    }
    
}