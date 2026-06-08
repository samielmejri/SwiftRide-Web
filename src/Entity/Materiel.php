<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Materiel
 *
 * @ORM\Table(name="materiel", indexes={@ORM\Index(name="id_garage", columns={"id_garage"})})
 * @ORM\Entity
 */
class Materiel
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
     * @ORM\Column(name="nom", type="string", length=11, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="disponibilité", type="integer", nullable=false)
     */
    private $disponibilité;

    /**
     * @var \Garage
     *
     * @ORM\ManyToOne(targetEntity="Garage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_garage", referencedColumnName="id")
     * })
     */
    private $idGarage;


}
