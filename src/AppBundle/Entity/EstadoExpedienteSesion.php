<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstadoExpedienteSesion
 *
 * @ORM\Table(name="estadoExpedienteSesion")
 * @ORM\Entity
 */
class EstadoExpedienteSesion
{
    //-----------------------------------atributos de la clase-------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idEstadoExpedienteSesion", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoExpedienteSesion", type="string", length=45, nullable=false)
     */
    private $estadoExpedienteSesion;

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
     * Set estadoExpedienteSesion
     *
     * @param string $estadoExpedienteSesion
     *
     * @return EstadoExpedienteSesion
     */
    public function setEstadoExpedienteSesion($estadoExpedienteSesion)
    {
    	$this->estadoExpedienteSesion = $estadoExpedienteSesion;

        return $this;
    }

    /**
     * Get estadoExpedienteSesion
     *
     * @return string
     */
    public function getEstadoExpedienteSesion()
    {
        return $this->estadoExpedienteSesion;
    }

}
