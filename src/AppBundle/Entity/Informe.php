<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Informe
 *
 * @ORM\Table(name="informe", indexes={@ORM\Index(name="informe_destino_idx", columns={"idDestino"}),
 *                                     @ORM\Index(name="informe_expediente_idx", columns={"idExpediente"})})
 *
 * @ORM\Entity
 */

class Informe {
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idInforme", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @var \AppBundle\Entity\Oficina
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Oficina")
	 * @ORM\JoinColumns({@ORM\JoinColumn(name="idDestino", referencedColumnName="idOficina")})
	 */
	private $destino;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="solicitud", type="string", length=200)
	 */
	private $solicitud;
	
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fechaEmision", type="datetime", nullable=true)
	 */
	private $fechaEmision;
	
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="$fechaIngresoRespuesta", type="datetime",nullable=true)
	 */
	private $fechaIngresoRespuesta;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="fojas", type="string", length=50, nullable=true)
	 */
	private $fojas;
	
	/**
	 * @var \AppBundle\Entity\Expediente
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Expediente", inversedBy="informes")
	 * @ORM\JoinColumns({@ORM\JoinColumn(name="idExpediente", referencedColumnName="idExpediente")})
	 */
	private $expediente;
	
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
	 * @ORM\Column(name="usuarioModificacion", type="string", length=70)
	 */
	private $usuarioModificacion;
	
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fechaModificacion", type="datetime")
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
	 * @param \AppBundle\Entity\Oficina $destino
	 *
	 * @return Informe
	 */
	public function setDestino(\AppBundle\Entity\Oficina $destino) {
		$this->destino = $destino;
		return $this;
	}
	
	/**
	 * Get solicitud
	 *
	 * @return string
	 */
	public function getSolicitud() {
		return $this->solicitud;
	}
	
	/**
	 * Set solicitud
	 *
	 * @param string $solicitud
	 *
	 * @return Informe
	 */
	public function setSolicitud($solicitud) {
		$this->solicitud = $solicitud;
		return $this;
	}
	
	/**
	 * Get fechaEmision
	 *
	 * @return \DateTime
	 */
	public function getFechaEmision() {
		return $this->fechaEmision;
	}
	
	/**
	 * Set fechaEmision
	 *
	 * @param \DateTime $fechaEmision
	 *
	 * @return Informe
	 */
	public function setFechaEmision(\DateTime $fechaEmision) {
		$this->fechaEmision = $fechaEmision;
		return $this;
	}
	
	/**
	 * Get fechaIngresoRespuesta
	 *
	 * @return \DateTime
	 */
	public function getFechaIngresoRespuesta() {
		return $this->fechaIngresoRespuesta;
	}
	
	/**
	 * Set fechaIngresoRespuesta
	 *
	 * @param \DateTime $fechaIngresoRespuesta
	 *
	 * @return Informe
	 */
	public function setFechaIngresoRespuesta(\DateTime $fechaIngresoRespuesta) {
		$this->fechaIngresoRespuesta = $fechaIngresoRespuesta;
		return $this;
	}
	
	/**
	 * Get fojas
	 *
	 * @return string
	 */
	public function getFojas() {
		return $this->fojas;
	}
	
	/**
	 * Set fojas
	 *
	 * @param string $fojas
	 *
	 * @return Informe
	 */
	public function setFojas($fojas) {
		$this->fojas = $fojas;
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
	 * @return Informe
	 */
	public function setExpediente(\AppBundle\Entity\Expediente $expediente) {
		$this->expediente = $expediente;
		return $this;
	}
	
	/**
	 * Get usuarioCreacion
	 *
	 * @return string
	 */
	public function getUsuarioCreacion() {
		return $this->usuarioCreacion;
	}
	
	/**
	 * Set usuarioCreacion
	 *
	 * @param string $usuarioCreacion
	 *
	 * @return Informe
	 */
	public function setUsuarioCreacion($usuarioCreacion) {
		$this->usuarioCreacion = $usuarioCreacion;
		return $this;
	}
	
	/**
	 * Get fechaCreacion
	 *
	 * @return \DateTime
	 */
	public function getFechaCreacion() {
		return $this->fechaCreacion;
	}
	
	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 *
	 * @return Informe
	 */
	public function setFechaCreacion(\DateTime $fechaCreacion) {
		$this->fechaCreacion = $fechaCreacion;
		return $this;
	}
	
	/**
	 * Get usuarioModificacion
	 *
	 * @return string
	 */
	public function getUsuarioModificacion() {
		return $this->usuarioModificacion;
	}
	
	/**
	 * Set usuarioModificacion
	 *
	 * @param string $usuarioModificacion
	 *
	 * @return Informe
	 */
	public function setUsuarioModificacion($usuarioModificacion) {
		$this->usuarioModificacion = $usuarioModificacion;
		return $this;
	}
	
	/**
	 * Get fechaModificacion
	 *
	 * @return \DateTime
	 */
	public function getFechaModificacion() {
		return $this->fechaModificacion;
	}
	
	/**
	 * Set fechaModificacion
	 *
	 * @param \DateTime $fechaModificacion
	 *
	 * @return Informe
	 */
	public function setFechaModificacion(\DateTime $fechaModificacion) {
		$this->fechaModificacion = $fechaModificacion;
		return $this;
	}
	
	//------------------------------Propiedades Virtuales -------------------------------------
	
	/**
	 * Get fechaEmisionFormateada
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getFechaEmisionFormateada()
	{
		return (!is_null($this->getFechaEmision())?$this->getFechaEmision()->format('d/m/Y'):'');
	}
	
	/**
	 * Get fechaIngresoRespuestaFormateada
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getFechaIngresoRespuestaFormateada()
	{
		return (!is_null($this->getFechaIngresoRespuesta())?$this->getFechaIngresoRespuesta()->format('d/m/Y'):'');
	}
}