<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoAutoridad
 *
 * @ORM\Table(name="tipoAutoridad")
 * @ORM\Entity
 */
class TipoAutoridad
{
    //--------------------------------------atributos de la clase---------------------------------
    
    /**
     * @var integer
     *
     * @ORM\Column(name="idTipoAutoridad", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoAutoridad", type="string", length=10, nullable=false)
     */
    private $tipoAutoridad;

    //------------------------------------setters y getters---------------------------------------

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
     * Set tipoAutoridad
     *
     * @param string $tipoAutoridad
     *
     * @return TipoAutoridad
     */
    public function setTipoAutoridad($tipoAutoridad)
    {
    	$this->tipoAutoridad = $tipoAutoridad;

        return $this;
    }

    /**
     * Get tipoAutoridad
     *
     * @return string
     */
    public function getTipoAutoridad()
    {
        return $this->tipoAutoridad;
    }
}
