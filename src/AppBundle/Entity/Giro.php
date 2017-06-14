<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Giro
 *
 * @ORM\Table(name="giro", indexes={@ORM\Index(name="giro_oficinaOrigen_idx", columns={"idOrigenGiro"}), 
 *                                         	  @ORM\Index(name="giro_oficinaDestino_idx", columns={"idDestinoGiro"}), 
 *                                            @ORM\Index(name="giro_expediente_idx", columns={"idExpediente"})})
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
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fechaEnvioRemito", type="datetime")
	 */
	private $fechaEnvioRemito;
	
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fechaRecepcionRemito", type="datetime", nullable=true)
	 */
	private $fechaRecepcionRemito;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="observacion", type="string", length=200, nullable=true)
	 */
	private $observacion;
	
	/**
	 * @var \AppBundle\Entity\Oficina
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Oficina")
	 * @ORM\JoinColumns({@ORM\JoinColumn(name="idDestinoGiro", referencedColumnName="idOficina")})
	 */
	private $destinoGiro;
	
	/**
	 * @var \AppBundle\Entity\Oficina
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Oficina")
	 * @ORM\JoinColumns({@ORM\JoinColumn(name="idOrigenGiro", referencedColumnName="idOficina")})
	 */
	private $origenGiro;
	
	/**
	 * @var \AppBundle\Entity\Expediente
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Expediente", inversedBy="giros")
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
	 * Get fechaEnvioRemito
	 *
	 * @return \DateTime
	 */
	public function getFechaEnvioRemito() {
		return $this->fechaEnvioRemito;
	}
	
	/**
	 * Set fechaEnvioRemito
	 *
	 * @param \DateTime $fechaEnvioRemito
	 *
	 * @return Giro
	 */
	public function setFechaEnvioRemito(\DateTime $fechaEnvioRemito) {
		$this->fechaEnvioRemito = $fechaEnvioRemito;
		return $this;
	}

	/**
	 * Get fechaRecepcionRemito
	 *
	 * @return \DateTime
	 */
	public function getFechaRecepcionRemito() {
		return $this->fechaRecepcionRemito;
	}
	
	/**
	 * Set fechaRecepcionRemito
	 *
	 * @param \DateTime $fechaRecepcionRemito
	 *
	 * @return Giro
	 */
	public function setFechaRecepcionRemito(\DateTime $fechaRecepcionRemito) {
		$this->fechaRecepcionRemito = $fechaRecepcionRemito;
		return $this;
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
	 * Get destinoGiro
	 *
	 * @return \AppBundle\Entity\Oficina
	 */
	public function getDestinoGiro() {
		return $this->destinoGiro;
	}
	
	/**
	 * Set destinoGiro
	 *
	 * @param  \AppBundle\Entity\Oficina $destinoGiro
	 * 
	 * @return Giro
	 */
	public function setDestinoGiro(\AppBundle\Entity\Oficina $destinoGiro) {
		$this->destinoGiro = $destinoGiro;
		return $this;
	}
	
	/**
	 * Get origenGiro
	 *
	 * @return \AppBundle\Entity\Oficina
	 */
	public function getOrigenGiro() {
		return $this->origenGiro;
	}
	
	/**
	 * Set origenGiro
	 *
	 * @param  \AppBundle\Entity\Oficina $origenGiro
	 *
	 * @return Giro
	 */
	public function setOrigenGiro( \AppBundle\Entity\Oficina $origenGiro) {
		$this->origenGiro = $origenGiro;
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
	 * @return Expediente
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
	 * @return Expediente
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
	 * @return Expediente
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
	 * Get fechaEnvioRemitoFormateada
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getFechaEnvioRemitoFormateada()
	{
		return (!is_null($this->getFechaEnvioRemito())?$this->getFechaEnvioRemito()->format('d/m/Y'):'');
	}
	
	/**
	 * Get fechaRecepcionRemitoFormateada
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getFechaRecepcionRemitoFormateada()
	{
		return (!is_null($this->getFechaRecepcionRemito())?$this->getFechaRecepcionRemito()->format('d/m/Y'):'');
	}
}