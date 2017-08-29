<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Sesion
 *
 * @ORM\Table(name="sesion", indexes={@ORM\Index(name="sesion_tipoSesion_idx", columns={"idTipoSesion"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SesionRepository")
 */
class Sesion
{
    //---------------------------------atributos de la clase------------------------------------


    /**
     * @var integer
     *
     * @ORM\Column(name="idSesion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=50, nullable=false)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="presentes", type="smallint", nullable=true)
     */
    private $presentes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="quorum", type="boolean", nullable=true)
     */
    private $quorum;

    /**
     * @var integer
     *
     * @ORM\Column(name="año", type="smallint", nullable=false)
     */
    private $año;
    
    /**
     * @var \AppBundle\Entity\TipoSesion
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoSesion")
     * @ORM\JoinColumns({
     * 		@ORM\JoinColumn(name="idTipoSesion", referencedColumnName="idTipoSesion")
     * })
     */
    private $tipoSesion;
    
    /**
     * @var tieneOrdenDelDia
     * 
     * @ORM\Column(name="tieneOrdenDelDia", type="boolean", nullable=false)
     */
    private $tieneOrdenDelDia;

    /**
     * @var tieneEdicionBloqueada
     *
     * @ORM\Column(name="tieneEdicionBloqueada", type="boolean", nullable=false)
     */
    private $tieneEdicionBloqueada;
    
    /**
     * @var cantidadExpedientes
     *
     * @ORM\Column(name="cantidadExpedientes", type="integer")
     */
    private $cantidadExpedientes;

    //-------------------------------------constructor----------------------------------------------

    /**
     * Constructor
     */
    public function __construct()
    {
        //$this->ordenDelDia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tieneOrdenDelDia=false;
        $this->tieneEdicionBloqueada=false;
        $this->quorum=false;
        $this->presentes=0;
        $this->cantidadExpedientes=0;
    }

    //------------------------------------setters y getters----------------------------------------

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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Sesion
     */
    public function setDescripcion($descripcion)
    {
    	$this->descripcion = $descripcion;
    	
    	return $this;
    }
    
    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
    	return $this->descripcion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Sesion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set presentes
     *
     * @param integer $presentes
     *
     * @return Sesion
     */
    public function setPresentes($presentes)
    {
        $this->presentes = $presentes;

        return $this;
    }

    /**
     * Get presentes
     *
     * @return integer
     */
    public function getPresentes()
    {
        return $this->presentes;
    }

    /**
     * Set quorum
     *
     * @param boolean $quorum
     *
     * @return Sesion
     */
    public function setQuorum($quorum)
    {
        $this->quorum = $quorum;

        return $this;
    }

    /**
     * Get quorum
     *
     * @return boolean
     */
    public function getQuorum()
    {
        return $this->quorum;
    }

    /**
     * Set año
     *
     * @param integer $año
     *
     * @return Sesion
     */
    public function setAño($año)
    {
    	$this->año = $año;

        return $this;
    }

    /**
     * Get año
     *
     * @return integer
     */
    public function getAño()
    {
        return $this->año;
    }
    
    /**
     * Set tipoSesion
     *
     * @param \AppBundle\Entity\TipoSesion $tipoSesion
     *
     * @return Sesion
     */
    public function setTipoSesion($tipoSesion)
    {
    	$this->tipoSesion = $tipoSesion;
    	
    	return $this;
    }
    
    /**
     * Get tipoSesion
     *
     * @return \AppBundle\Entity\TipoSesion $tipoSesion
     */
    public function getTipoSesion()
    {
    	return $this->tipoSesion;
    }
    
    /**
     * Get tieneOrdenDelDia
     * 
     * @return boolean
     */
	public function getTieneOrdenDelDia() {
		return $this->tieneOrdenDelDia;
	}
	
	/**
	 * Set tieneOrdenDelDia
	 * 
	 * @param boolean $tieneOrdenDelDia
	 * @return Sesion
	 */
	public function setTieneOrdenDelDia($tieneOrdenDelDia) {
		$this->tieneOrdenDelDia = $tieneOrdenDelDia;
		return $this;
	}
	
	/**
	 * Get tieneEdicionBloqueada
	 *
	 * @return boolean
	 */
	public function getTieneEdicionBloqueada() {
		return $this->tieneEdicionBloqueada;
	}
	
	/**
	 * Set tieneEdicionBloqueada
	 *
	 * @param boolean $tieneEdicionBloqueada
	 * @return Sesion
	 */
	public function setTieneEdicionBloqueada($tieneEdicionBloqueada) {
		$this->tieneEdicionBloqueada = $tieneEdicionBloqueada;
		return $this;
	}
	
	/**
	 * Get cantidadExpedientes
	 *
	 * @return integer
	 */
	public function getCantidadExpedientes() {
		return $this->cantidadExpedientes;
	}
	
	/**
	 * Set cantidadExpedientes
	 *
	 * @param integer $cantidadExpedientes
	 * @return Sesion
	 */
	public function setCantidadExpedientes($cantidadExpedientes) {
		$this->cantidadExpedientes = $cantidadExpedientes;
		return $this;
	}
	    
    //--------------------------------Propiedades Virtuales-----------------------------------
    
    /**
     * Get fechaFormateada
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getFechaFormateada()
    {
    	return $this->fecha->format('d/m/Y');
    }
    
    /**
     * Get fechaMuestra
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getFechaMuestra()
    {
    	return $this->fecha->format('d/m/Y').'('.$this->getTipoSesion()->getAbreviacion().')';
    }
    
    
}
