<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoSesion
 *
 * @ORM\Table(name="tipoSesion")
 * @ORM\Entity
 */
class TipoSesion
{
    //-----------------------------------------atributos de la clase-------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idTipoSesion", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoSesion", type="string", length=50, nullable=false)
     */
    private $tipoSesion;

    /**
     * @var string
     *
     * @ORM\Column(name="$abreviacion", type="string", length=2, nullable=false)
     */
    private $abreviacion;

    //-------------------------------------setters y getters--------------------------------------

    
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
     * Set tipoSesion
     *
     * @param string $tipoSesion
     *
     * @return TipoSesion
     */
    public function setTipoSesion($tipoSesion)
    {
    	$this->tipoSesion = $tipoSesion;

        return $this;
    }

    /**
     * Get tipoSesion
     *
     * @return string
     */
    public function getTipoSesion()
    {
        return $this->tipoSesion;
    }

    /**
     * Set abreviacion
     *
     * @param string $abreviacion
     *
     * @return TipoSesion
     */
    public function setAbreviacion($abreviacion)
    {
    	$this->abreviacion = $abreviacion;
    	
    	return $this;
    }
    
    /**
     * Get abreviacion
     *
     * @return string
     */
    public function getAbreviacion()
    {
    	return $this->abreviacion;
    }

  



}
