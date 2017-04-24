<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstadoAgendaSesion
 *
 * @ORM\Table(name="estadoAgendaSesion")
 * @ORM\Entity
 */
class EstadoAgendaSesion
{
    //-----------------------------------atributos de la clase-------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idEstadoAgendaSesion", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoAgendaSesion", type="string", length=45, nullable=false)
     */
    private $estadoAgendaSesion;

    //-----------------------------------setters y getters-----------------------------------------

    
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
     * Set estadoAgendaSesion
     *
     * @param string $estadoAgendaSesion
     *
     * @return EstadoAgendaSesion
     */
    public function setEstadoAgendaSesion($estadoAgendaSesion)
    {
        $this->estadoAgendaSesion = $estadoAgendaSesion;

        return $this;
    }

    /**
     * Get estadoAgendaSesion
     *
     * @return string
     */
    public function getEstadoAgendaSesion()
    {
        return $this->estadoAgendaSesion;
    }

}
