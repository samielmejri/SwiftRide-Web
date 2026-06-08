<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MoyenTransportStationRepository")
 */
class MoyenTransportStation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MoyenTransport", inversedBy="moyenTransportStations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $moyenTransport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Station", inversedBy="moyenTransportStations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $station;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoyenTransport(): ?MoyenTransport
    {
        return $this->moyenTransport;
    }

    public function setMoyenTransport(?MoyenTransport $moyenTransport): self
    {
        $this->moyenTransport = $moyenTransport;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): self
    {
        $this->station = $station;

        return $this;
    }

   
}
