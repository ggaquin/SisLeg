<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Bloque
 *
 * @ORM\Table(name="bloque")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BloqueRepository")
 */
class Bloque
{
    //-----------------------------------------atributos de la clase-------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idBloque", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="bloque", type="string", length=100, nullable=false)
     */
    private $bloque;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PerfilLegislador", mappedBy="bloque")
     */
    private $concejales;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", nullable=false)
     */
    private $activo;
    
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
    
    //------------------------------------constructor---------------------------------------------
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->concejales = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->activo=true;
    }

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
     * Set bloque
     *
     * @param string $bloque
     *
     * @return Bloque
     */
    public function setBloque($bloque)
    {
        $this->bloque = $bloque;

        return $this;
    }

    /**
     * Get bloque
     *
     * @return string
     */
    public function getBloque()
    {
        return $this->bloque;
    }
    
    /**
     * Add concejal
     *
     * @param \AppBundle\Entity\PerfilLegislador $concejal
     *
     * @return Bloque
     */
    public function addConcejal(\AppBundle\Entity\PerfilLegislador $concejal)
    {
    	$this->concejales[] = $concejal;
    	
    	return $this;
    }
    
    /**
     * Remove concejal
     *
     * @param \AppBundle\Entity\PerfilLegislador $concejal
     */
    public function removeConcejal(\AppBundle\Entity\PerfilLegislador $concejal)
    {
    	$this->concejales->removeElement($concejal);
    }
    
    /**
	 * Get concejales
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getConcejales()
	{
		return $this->concejales;
	}
	
	/**
	 * Set activo
	 *
	 * @param boolean $activo
	 *
	 * @return Bloque
	 */
	public function setActivo($activo)
	{
		$this->activo = $activo;
		
		return $this;
	}
	
	/**
	 * Get activo
	 *
	 * @return boolean
	 */
	public function getActivo()
	{
		return $this->activo;
	}
	
	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 *
	 * @return Bloque
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
	 * @return Bloque
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
	 * @return Bloque
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
	 * @return Bloque
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
	 * Get listaConcejales
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getListaConcejales()
	{
		$concejales=$this->concejales;
		$listaConcejales="";
		foreach ($concejales as $concejal) {
			$listaConcejales.=($listaConcejales!=""?"-":"").$concejal->getNombreCompleto();
		}
		return $listaConcejales;
	}
	
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
