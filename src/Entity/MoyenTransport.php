<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MoyenTransportRepository;

#[ORM\Entity(repositoryClass: MoyenTransportRepository::class)]
class MoyenTransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(length:25)]
    private $type;

    #[ORM\Column]
    private $numeroTrans;


}
