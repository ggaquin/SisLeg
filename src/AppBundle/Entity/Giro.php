<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Giro
 *
 * @ORM\Table(name="giro", indexes={@ORM\Index(name="giro_remitoGiros_idx", columns={"idRemitoGiros"}), 
 *                                  @ORM\Index(name="giro_expediente_idx", columns={"idExpediente"})})
 *
 * @ORM\Entity
 */

class Giro {
	
	/**
	* @var integer
	*
	* @ORM\Column(name="idGiro", type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="IDENTITY")
	*/
	private $id;
	
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
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RemitoGiros", inversedBy="giros")
	 * @ORM\JoinColumns({@ORM\JoinColumn(name="idRemitoGiros", referencedColumnName="idRemitoGiros")})
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
	 * @ORM\Column(name="eliminado", type="boolean", nullable=false)
	 */
	private $eliminado;
		
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
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
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
	 * @return Giro
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
	 * @return Giro
	 */
	public function setExpediente(\AppBundle\Entity\Expediente $expediente) {
		$this->expediente = $expediente;
		return $this;
	}
	
	/**
	 * Get remito
	 *
	 * @return \AppBundle\Entity\RemitoGiros
	 */
	public function getRemito() {
		return $this->remito;
	}
	
	/**
	 * Set remito
	 *
	 * @param \AppBundle\Entity\RemitoGiros $remito
	 *
	 * @return Giro
	 */
	public function setRemito(\AppBundle\Entity\RemitoGiros $remito) {
		$this->remito = $remito;
		return $this;
	}
	
	/**
	 * Set fojas
	 *
	 * @param integer $fojas
	 *
	 * @return Giro
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
	 * Set eliminado
	 *
	 * @param boolean $eliminado
	 *
	 * @return Giro
	 */
	public function setEliminado($eliminado)
	{
		$this->eliminado = $eliminado;
		
		return $this;
	}
	
	/**
	 * Get eliminado
	 *
	 * @return integer
	 */
	public function getEliminado()
	{
		return $this->eliminado;
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