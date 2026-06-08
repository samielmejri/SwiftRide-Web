<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Maintenance
 *
 * @ORM\Table(name="maintenance", indexes={@ORM\Index(name="id_garage", columns={"id_garage"}), @ORM\Index(name="id_voiture", columns={"id_voiture"})})
 * @ORM\Entity
 */
class Maintenance
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_maintenance", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateMaintenance = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=25, nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin_maintenance", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $finMaintenance = 'CURRENT_TIMESTAMP';

    /**
     * @var \Garage
     *
     * @ORM\ManyToOne(targetEntity="Garage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_garage", referencedColumnName="id")
     * })
     */
    private $idGarage;

    /**
     * @var \Voiture
     *
     * @ORM\ManyToOne(targetEntity="Voiture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_voiture", referencedColumnName="id")
     * })
     */
    private $idVoiture;


}
