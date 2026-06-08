<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Garage
 *
 * @ORM\Table(name="garage")
 * @ORM\Entity
 */
class Garage
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
     * @ORM\Column(name="matricule_garage", type="string", length=40, nullable=false)
     */
    private $matriculeGarage;

    /**
     * @var int
     *
     * @ORM\Column(name="surface", type="integer", nullable=false)
     */
    private $surface;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=150, nullable=false)
     */
    private $localisation;


}
