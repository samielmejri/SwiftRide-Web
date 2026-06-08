<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MoyenTransport
 *
 * @ORM\Table(name="moyen_transport")
 * @ORM\Entity
 */
class MoyenTransport
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
     * @ORM\Column(name="type", type="string", length=25, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_trans", type="integer", nullable=false)
     */
    private $numeroTrans;


}
