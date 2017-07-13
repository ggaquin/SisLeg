<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Movimiento
 *
 * @ORM\Table(name="movimiento", indexes={@ORM\Index(name="movimiento_remito_idx", columns={"idRemito"}), 
 *                                        @ORM\Index(name="movimiento_expediente_idx", columns={"idExpediente"}),
 *                                        @ORM\Index(name="movimiento_tipoMovimiento_idx", columns={"idTipoMovimiento"})})
 *
 * @ORM\Entity
 */

class Movimiento {
	
	/**
	* @var integer
	*
	* @ORM\Column(name="idMovimiento", type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="IDENTITY")
	*/
	private $id;
	
	/**
	 * @var \AppBundle\Entity\TipoMovimiento
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Movimiento")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="idTipoMovimiento", referencedColumnName="idTipoMovimiento")
	 * })
	 */
	private $tipoMovimiento;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="observacion", type="string", length=200, nullable=true)
	 */
	private $observacion;
	
	
	/**
	 * @var \AppBundle\Entity\Expediente
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Expediente", inversedBy="giros")
	 * @ORM\JoinColumns({@ORM\JoinColumn(name="idExpediente", referencedColumnName="idExpediente")})
	 */
	private $expediente;
	
	/**
	 * @var \AppBundle\Entity\RemitoGiros
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Remito", inversedBy="movimientos")
	 * @ORM\JoinColumns({@ORM\JoinColumn(name="idRemito", referencedColumnName="idRemito")})
	 */
	private $remito;
	
	/**
	 * @var smallint
	 *
	 * @ORM\Column(name="fojas", type="smallint", nullable=false)
	 */
	private $fojas;
	
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="anulado", type="boolean", nullable=true)
	 */
	private $anulado;
		
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
		$this->anulado=false;
	}
	
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set tipoMovimiento
	 *
	 * @param \AppBundle\Entity\TipoMovimiento $tipoMovimiento
	 *
	 * @return Movimiento
	 */
	public function setTipoMovimiento(\AppBundle\Entity\TipoMovimiento $tipoMovimiento= null)
	{
		$this->tipoMovimiento = $tipoMovimiento;
		return $this;
	}
	
	/**
	 * Get tipoMovimiento
	 *
	 * @return \AppBundle\Entity\TipoMovimiento
	 */
	public function getTipoMovimiento()
	{
		return $this->tipoMovimiento;
	}
	
	/**
	 * Get observacion
	 *
	 * @return string
	 */
	public function getObservacion() {
		return $this->observacion;
	}
	
	/**
	 * Set observacion
	 *
	 * @param string $observacion
	 *
	 * @return Movimiento
	 */
	public function setObservacion($observacion) {
		$this->observacion = $observacion;
		return $this;
	}
	
	/**
	 * Get expediente
	 *
	 * @return \AppBundle\Entity\Expediente
	 */
	public function getExpediente() {
		return $this->expediente;
	}
	
	/**
	 * Set expediente
	 *
	 * @param \AppBundle\Entity\Expediente $expediente
	 *
	 * @return Movimiento
	 */
	public function setExpediente(\AppBundle\Entity\Expediente $expediente) {
		$this->expediente = $expediente;
		return $this;
	}
	
	/**
	 * Get remito
	 *
	 * @return \AppBundle\Entity\Remito
	 */
	public function getRemito() {
		return $this->remito;
	}
	
	/**
	 * Set remito
	 *
	 * @param \AppBundle\Entity\Remito $remito
	 *
	 * @return Movimiento
	 */
	public function setRemito(\AppBundle\Entity\Remito $remito) {
		$this->remito = $remito;
		return $this;
	}
	
	/**
	 * Set fojas
	 *
	 * @param integer $fojas
	 *
	 * @return Movimiento
	 */
	public function setFojas($fojas)
	{
		$this->fojas = $fojas;
		
		return $this;
	}
	
	/**
	 * Get fojas
	 *
	 * @return integer
	 */
	public function getFojas()
	{
		return $this->fojas;
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
	 * Get anulado
	 *
	 * @return boolean
	 */
	public function getAnulado()
	{
		return $this->anulado;
	}
	
	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 *
	 * @return Movimiento
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
	 * @return Movimiento
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
	 * @return Movimiento
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
	 * @return Movimiento
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
	 * Get fechaEnvio
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getFechaEnvio()
	{
		return ((!is_null($this->getRemito()))?$this->getRemito()->getFechaMovimientoFormateada():'');
	}
	
	/**
	 * Get fechaRecepcion
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getFechaRecepcion()
	{
		return ((!is_null($this->getRemito()))?$this->getRemito()->getFechaRecepcionFormateada():'');
	}
	
	/**
	 * Get origen
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getOrigen()
	{
		return ((!is_null($this->getRemito()))?$this->getRemito()->getOrigen()->getOficina():'');
	}
	
	/**
	 * Get destino
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getDestino()
	{
		return ((!is_null($this->getRemito()))?$this->getRemito()->getDestino()->getOficina():'');
	}
}