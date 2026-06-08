<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity
 */
class Reservation
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
     * @ORM\Column(name="point_depart", type="string", length=255, nullable=false)
     */
    private $pointDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=255, nullable=false)
     */
    private $destination;

    /**
     * @var int
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     */
    private $idClient;

    /**
     * @var int
     *
     * @ORM\Column(name="id_vehicule", type="integer", nullable=false)
     */
    private $idVehicule;

    /**
     * @var string
     *
     * @ORM\Column(name="temps_depart", type="string", length=255, nullable=false)
     */
    private $tempsDepart;

    /**
     * @var float|null
     *
     * @ORM\Column(name="distance", type="float", precision=10, scale=0, nullable=true)
     */
    private $distance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_transport", type="string", length=255, nullable=true)
     */
    private $typeTransport;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="past", type="integer", nullable=false)
     */
    private $past;


}
