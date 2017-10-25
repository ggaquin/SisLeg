<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use Doctrine\ORM\Mapping\JoinColumn;
use AppBundle\AppBundle;

/**
 * VersionTaquigrafica
 *
 * @ORM\Table(name="versionTaquigrafica", 
 * 			  indexes={@ORM\Index(name="versionTaquigrafica_sesion_idx",columns={"idSesion"})}
 * 			 )
 * @ORM\Entity()
 */
class VersionTaquigrafica
{
    //-----------------------------------------atributos de la clase-------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idVersionTaquigrafica", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var text
     *
     * @ORM\Column(name="descripcion", type="text", nullable=false)
     */
    private $descripcion;
    
    /**
     * @var \AppBundle\Entity\Sesion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sesion")
     * @JoinColumn(name="idSesion", referencedColumnName="idSesion")
     * 
     */
    private $sesion;
        
    /**
     * @var string
     *
     * @ORM\Column(name="usuarioCreacion", type="string", length=70, nullable=false)
     */
    private $usuarioCreacion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="usuarioModificacion", type="string", length=70, nullable=true)
     */
    private $usuarioModificacion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificacion", type="datetime", nullable=true)
     */
    private $fechaModificacion;
    
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
     * Set decripcion
     *
     * @param string $descripcion
     *
     * @return VersionTaquigrafica
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get decripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
       
    /**
     * Set sesion
     *
     * @param \AppBundle\Entity\Sesion $sesion
     * 
     * @return VersionTaquigrafica
     */
    public function setSesion(\AppBundle\Entity\Sesion $sesion)
    {
    	$this->sesion=$sesion;
    	
    	return $this;
    }
    
    /**
	 * Get sesion
	 *
	 * @return \AppBundle\Entity\Sesion
	 */
	public function getSesion()
	{
		return $this->sesion;
	}
		
	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 *
	 * @return VersionTaquigrafica
	 */
	public function setFechaCreacion($fechaCreacion)
	{
		$this->fechaCreacion = $fechaCreacion;
		
		return $this;
	}
	
	/**
	 * Get fechaCreacion
	 *
	 * @return \DateTime
	 */
	public function getFechaCreacion()
	{
		return $this->fechaCreacion;
	}
	
	/**
	 * Set usuarioCreacion
	 *
	 * @param string $usuarioCreacion
	 *
	 * @return VersionTaquigrafica
	 */
	public function setUsuarioCreacion($usuarioCreacion)
	{
		$this->usuarioCreacion = $usuarioCreacion;
		
		return $this;
	}
	
	/**
	 * Get usuarioCreacion
	 *
	 * @return string
	 */
	public function getUsuarioCreacion()
	{
		return $this->usuarioCreacion;
	}
	
	/**
	 * Set fechaModificacion
	 *
	 * @param \DateTime $fechaModificacion
	 *
	 * @return VersionTaquigrafica
	 */
	public function setFechaModificacion($fechaModificacion)
	{
		$this->fechaModificacion = $fechaModificacion;
		
		return $this;
	}
	
	/**
	 * Get fechaModificacion
	 *
	 * @return \DateTime
	 */
	public function getFechaModificacion()
	{
		return $this->fechaModificacion;
	}
	
	/**
	 * Set usuarioModificacion
	 *
	 * @param string $usuarioModificacion
	 *
	 * @return VersionTaquigrafica
	 */
	public function setUsuarioModificacion($usuarioModificacion)
	{
		$this->usuarioModificacion = $usuarioModificacion;
		
		return $this;
	}
	
	/**
	 * Get usuarioModificacion
	 *
	 * @return string
	 */
	public function getUsuarioModificacion()
	{
		return $this->usuarioModificacion;
	}
	
	//------------------------------Propiedades virtuales-----------------------------------------
	
	/**
	 * Get fechaCreacionFormateada
	 * 
	 * @return string
	 * 
	 * @VirtualProperty
	 */
	public function getFechaCreacionFormateada()
	{
		return $this->getFechaCreacion()->format('d/m/Y');
	}
	
    
}
