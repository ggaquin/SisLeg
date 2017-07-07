<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * RemitoGiros
 *
 * @ORM\Table(name="remitoGiros", indexes={@ORM\Index(name="remitoGiros_oficinaOrigen_idx", columns={"idOrigen"}),
 *                                  	   @ORM\Index(name="remitoGiros_oficinaDestino_idx", columns={"idDestino"})})
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RemitoGirosRepository")
 */

class RemitoGiros{
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idRemitoGiros", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
		
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fechaRecepcion", type="datetime", nullable=true)
	 */
	private $fechaRecepcion;
	
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="anulado", type="boolean", nullable=true)
	 */
	private $anulado;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="motivoAnulacion", type="string", length=150, nullable=true)
	 */
	private $motivoAnulacion;
	
	/**
	 * @var \AppBundle\Entity\Oficina
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Oficina")
	 * @ORM\JoinColumns({@ORM\JoinColumn(name="idDestino", referencedColumnName="idOficina")})
	 */
	private $destino;
	
	/**
	 * @var \AppBundle\Entity\Oficina
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Oficina")
	 * @ORM\JoinColumns({@ORM\JoinColumn(name="idOrigen", referencedColumnName="idOficina")})
	 */
	private $origen;
	
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
	
	/**
	 * @var \Doctrine\Common\Collections\Collection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Giro", mappedBy="remiroGiro",
	 * 				  cascade={"persist", "remove"},orphanRemoval=true)
	 */
	private $giros;
	
	//------------------------------------constructor---------------------------------------------
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->giros = new \Doctrine\Common\Collections\ArrayCollection();
		$this->anulado=false;
	}
	
	//-------------------------------setters y getters--------------------------------------------
	
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Get fechaRecepcion
	 *
	 * @return \DateTime
	 */
	public function getFechaRecepcion() {
		return $this->fechaRecepcion;
	}
	
	/**
	 * Set fechaRecepcion
	 *
	 * @param \DateTime $fechaRecepcion
	 *
	 * @return Giro
	 */
	public function setFechaRecepcion(\DateTime $fechaRecepcion) {
		$this->fechaRecepcion = $fechaRecepcion;
		return $this;
	}
	
	/**
	 * Set anulado
	 *
	 * @param boolean $anulado
	 *
	 * @return Giro
	 */
	public function setAnulado($anulado)
	{
		$this->anulado= $anulado;
		
		return $this;
	}
	
	/**
	 * Get $anulado
	 *
	 * @return boolean
	 */
	public function getAnulado()
	{
		return $this->anulado;
	}
	
	/**
	 * Set motivoAnulacion
	 *
	 * @param string $motivoAnulacion
	 *
	 * @return Giro
	 */
	public function setMotivoAnulacion($motivoAnulacion)
	{
		$this->motivoAnulacion= $motivoAnulacion;
		
		return $this;
	}
	
	/**
	 * Get motivoAnulacion
	 *
	 * @return string
	 */
	public function getMotivoAnulacion()
	{
		return $this->motivoAnulacion;
	}
		
	/**
	 * Get destino
	 *
	 * @return \AppBundle\Entity\Oficina
	 */
	public function getDestino() {
		return $this->destino;
	}
	
	/**
	 * Set destino
	 *
	 * @param  \AppBundle\Entity\Oficina $destino
	 *
	 * @return RemitoGiros
	 */
	public function setDestino(\AppBundle\Entity\Oficina $destino) {
		$this->destino = $destino;
		return $this;
	}
	
	/**
	 * Get origen
	 *
	 * @return \AppBundle\Entity\Oficina
	 */
	public function getOrigen() {
		return $this->origen;
	}
	
	/**
	 * Set origen
	 *
	 * @param  \AppBundle\Entity\Oficina $origen
	 *
	 * @return RemitoGiros
	 */
	public function setOrigen( \AppBundle\Entity\Oficina $origen) {
		$this->origen = $origen;
		return $this;
	}
	
	/**
	 * set giros
	 *
	 * @param array $nuevosGiros
	 *
	 * @return RemitoGiros
	 */
	public function setGiros($nuevosGiros)
	{
		$collection= new \Doctrine\Common\Collections\ArrayCollection();
		foreach ($nuevosGiros as $giro) {
			$giro->setRemito($this);
			$collection[]=$giro;
		}
		$this->giros = $collection;
		
		return $this;
	}
	
	/**
	 * Add giro
	 *
	 * @param \AppBundle\Entity\Giro $giro
	 *
	 * @return RemitoGiros
	 */
	public function addGiro(\AppBundle\Entity\Giro $giro)
	{
		$giro->setRemito($this);
		$this->giros[] = $giro;
		
		return $this;
	}
	
	/**
	 * Remove giro
	 *
	 * @param \AppBundle\Entity\Giro $giro
	 *
	 * @return RemitoGiros
	 */
	public function removeGiro(\AppBundle\Entity\Giro $giro)
	{
		$this->giros->removeElement($giro);
		return $this;
	}
	
	/**
	 * Get giros
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getGiros()
	{
		return $this->giros;
	}
	
	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 *
	 * @return Giro
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
	 * @return Giro
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
	 * @return Giro
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
	 * @return Giro
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
	
	//------------------------------Propiedades Virtuales -------------------------------------
	
	/**
	 * Get fechaMovimientoFormateada
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getFechaMovimientoFormateada()
	{
		return $this->getFechaCreacion()->format('d/m/Y');
	}
	
	/**
	 * Get fechaRecepcionFormateada
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getFechaRecepcionFormateada()
	{
		return (!is_null($this->getFechaRecepcion())?$this->getFechaRecepcion()->format('d/m/Y'):'');
	}
	
	/**
	 * Get listaExpedientes
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getListaExpedientes()
	{
		$expedientes="";
		$girosAux=(!is_null($this->getGiros())?$this->getGiros():[]);
		foreach ($girosAux as $giro){
			$expedientes.=$giro->getExpediente()->getNumeroCompleto();
		}
		return $expedientes;
	}
}