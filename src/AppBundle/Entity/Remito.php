<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Remito
 *
 * @ORM\Table(name="remito", indexes={@ORM\Index(name="remito_oficinaOrigen_idx", columns={"idOrigen"}),
 *                                    @ORM\Index(name="remito_oficinaDestino_idx", columns={"idDestino"})})
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RemitoRepository")
 */

class Remito{
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idRemito", type="integer")
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
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Movimiento", mappedBy="remito",
	 * 				  cascade={"persist", "remove"},orphanRemoval=true)
	 */
	private $movimientos;
	
	//------------------------------------constructor---------------------------------------------
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->movimientos = new \Doctrine\Common\Collections\ArrayCollection();
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
	 * @return Remito
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
	 * @return Movimiento
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
	 * @return Movimiento
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
	 * @return Remito
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
	 * @return Remito
	 */
	public function setOrigen( \AppBundle\Entity\Oficina $origen) {
		$this->origen = $origen;
		return $this;
	}
	
	/**
	 * set movimientos
	 *
	 * @param array $nuevosMovimientos
	 *
	 * @return Remito
	 */
	public function setMovimientos($nuevosMovimientos)
	{
		$collection= new \Doctrine\Common\Collections\ArrayCollection();
		foreach ($nuevosMovimientos as $movimiento) {
			$movimiento->setRemito($this);
			$collection[]=$movimiento;
		}
		$this->movimientos = $collection;
		
		return $this;
	}
	
	/**
	 * Add movimiento
	 *
	 * @param \AppBundle\Entity\Movimiento $movimiento
	 *
	 * @return Remito
	 */
	public function addMovimiento(\AppBundle\Entity\Movimiento $movimiento)
	{
		$movimiento->setRemito($this);
		$this->movimientos[] = $movimiento;
		
		return $this;
	}
	
	/**
	 * Remove movimiento
	 *
	 * @param \AppBundle\Entity\Movimiento $movimiento
	 *
	 * @return Remito
	 */
	public function removeMovimiento(\AppBundle\Entity\Movimiento $movimiento)
	{
		$this->movimientos->removeElement($movimiento);
		return $this;
	}
	
	/**
	 * Get movimientos
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getMovimientos()
	{
		return $this->movimientos;
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
		$movimientosAux=(!is_null($this->getMovimientos())?$this->getMovimientos():[]);
		foreach ($movimientosAux as $movimiento){
			$expedientes.=$movimiento->getExpediente()->getNumeroCompleto();
		}
		return $expedientes;
	}
}