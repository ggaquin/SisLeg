<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstadoExpediente
 *
 * @ORM\Table(name="estadoExpediente")
 * @ORM\Entity
 */
class EstadoExpediente
{
    //------------------------------------atributos de la clase-----------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idEstadoExpediente", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoExpediente", type="string", length=45, nullable=false)
     */
    private $estadoExpediente;

    //----------------------------------setters y getters-----------------------------------------

    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set estadoExpediente
     *
     * @param string $estadoExpediente
     *
     * @return EstadoExpediente
     */
    public function setEstadoExpediente($estadoExpediente)
    {
        $this->estadoExpediente = $estadoExpediente;

        return $this;
    }

    /**
     * Get estadoExpediente
     *
     * @return string
     */
    public function getEstadoExpediente()
    {
        return $this->estadoExpediente;
    }

}
