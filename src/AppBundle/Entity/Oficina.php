<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Oficina
 *
 * @ORM\Table(name="oficina",indexes={@ORM\Index(name="oficina_tipoOficina_idx", columns={"idTipoOficina"})})
 * 
 * @ORM\Entity
 */

class Oficina {
	
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idOficina", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="oficina", type="string", length=100, nullable=false)
	 */
	private $oficina;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="codigo", type="string", length=15, nullable=false)
	 */
	private $codigo;
	
	/**
	 * @var \AppBundle\Entity\TipoOficina
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoOficina")
	 * @ORM\JoinColumns({@ORM\JoinColumn(name="idTipoOficina", referencedColumnName="idTipoOficina")})
	 */
	private $tipoOficina;
	
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="activa", type="boolean", nullable=false)
	 */
	private $activa;
	
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
    	$this->activa=true;
    }
	
	//------------------------------------setters y getters ----------------------------------------
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * get oficina
	 *
	 * @return string
	 */
	public function getOficina() {
		return $this->oficina;
	}
	
	/**
	 * Set oficina
	 *
	 * @param string $oficina
	 *
	 * @return Oficina
	 */
	public function setOficina($oficina) {
		$this->oficina = $oficina;
		return $this;
	}
	
	/**
	 * get codigo
	 *
	 * @return string
	 */
	public function getCodigo() {
		return $this->codigo;
	}
	
	/**
	 * Set codigo
	 *
	 * @param string $codigo
	 *
	 * @return Oficina
	 */
	public function setCodigo($codigo) {
		$this->codigo = $codigo;
		return $this;
	}
	
	/**
	 * Get tipoOficina
	 *
	 * @return \AppBundle\Entity\TipoOficina
	 */
	public function getTipoOficina() {
		return $this->tipoOficina;
	}
	
	/**
	 * Set tipoOficina
	 *
	 * @param \AppBundle\Entity\TipoOficina $tipoOficina
	 *
	 * @return Oficina
	 */
	public function setTipoOficina(\AppBundle\Entity\TipoOficina $tipoOficina) {
		$this->tipoOficina = $tipoOficina	;
		return $this;
	}
	
	/**
	 * Set activa
	 *
	 * @param boolean $activa
	 *
	 * @return Comision
	 */
	public function setActiva($activa)
	{
		$this->activa = $activa;
		
		return $this;
	}
	
	/**
	 * Get activa
	 *
	 * @return boolean
	 */
	public function getActiva()
	{
		return $this->activa;
	}
	
	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 *
	 * @return Oficina
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
	 * @return Oficina
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
	 * @return Oficina
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
	 * @return Oficina
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
	 * Get esExterna
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getEsExterna()
	{   return ($this->tipoOficina->getTipoOficina()=="Externa");}
	
	/**
	 * Get descripcion
	 * 
	 * @return string 
	 * 
	 * @VirtualProperty
	 */
	public function getDescripcion(){
		$descripcion="";
		if ($this->tipoOficina->getTipoOficina()=="Externa")
			$descripcion=$this->getOficina()."- (".$this->getCodigo().")";
		else 
			$descripcion=$this->getOficina();
		
		return  $descripcion;
	}
			
}