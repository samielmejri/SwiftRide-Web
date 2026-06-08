<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use DateTime ;

/**
 * Voiture
 *
 * @ORM\Table(name="voiture")
 * @ORM\Entity
 */
class Voiture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=150, nullable=false)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=150, nullable=false)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=150, nullable=false)
     */
    private $matricule;

    /**
     * @var string
     *
     * @ORM\Column(name="CarteGrise", type="string", length=150, nullable=false)
     */
    private $cartegrise;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", length=150, nullable=false)
     */
    private $couleur;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=150, nullable=false)
     */
    private $etat;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="kilometrage", type="integer", nullable=false)
     */
    private $kilometrage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=150, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=150, nullable=false)
     */
    private $position;

    /**
     * @var int
     *
     * @ORM\Column(name="entreprise_id", type="integer", nullable=false)
     */
    private $entrepriseId;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="Date_ajout", type="datetime", length=150, nullable=false)
     */
    private $dateAjout;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
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

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
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

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
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

    public function getEntrepriseId(): ?int
    {
        return $this->entrepriseId;
    }

    public function setEntrepriseId(int $entrepriseId): self
    {
        $this->entrepriseId = $entrepriseId;

        return $this;
    }

    public function getDateAjout(): ?DateTime
    {
        return $this->dateAjout;
    }

    public function setDateAjout(DateTime $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }


}
