<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Notificacion
 *
 * @ORM\Entity
 */

class Notificacion extends Movimiento{
	
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fechaRespuesta", type="datetime", nullable=true)
	 */
	private $fechaRespuesta;
	
	/**
	 * @var \AppBundle\Entity\Sesion
	 * 
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sesion") 
	 * @ORM\JoinColumns({
	 * 	@ORM\JoinColumn(name="idSesion", referencedColumnName="idSesion")
	 * })
	 */
	private $sesion; 
	
	
	/**
	 * @var \AppBundle\Entity\Comision
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Comision")
	 * @ORM\JoinColumns({
	 * 	@ORM\JoinColumn(name="idComision", referencedColumnName="idComision")
	 * })
	 */
	private $comision;
		
	//-----------------------------------setters y getters--------------------------------------
		
	/**
	 * Set sesion
	 *
	 * @param \AppBundle\Entity\Sesion $sesion
	 *
	 * @return Notificacion
	 */
	public function setSesion(\AppBundle\Entity\Sesion $sesion= null)
	{
		$this->sesion = $sesion;
		return $this;
	}
	
	/**
	 * Get sesion
	 *
	 * @return \AppBundle\Entity\Sesion
	 */
	public function getSesion()
	{
		return $this->tipoMovimiento;
	}
	
	/**
	 * Set comision
	 *
	 * @param \AppBundle\Entity\Comision $comision
	 *
	 * @return Notificacion
	 */
	public function setComision(\AppBundle\Entity\Comision $comision= null)
	{
		$this->comision = $comision;
		return $this;
	}
	
	/**
	 * Get comision
	 *
	 * @return \AppBundle\Entity\Comision
	 */
	public function getComision()
	{
		return $this->comision;
	}
	
	
	/**
	 * Set fechaRespuesta
	 *
	 * @param \DateTime $fechaRespuesta
	 *
	 * @return Notificacion
	 */
	public function setFechaRespuesta($fechaRespuesta)
	{
		$this->fechaRespuesta = $fechaRespuesta;
		
		return $this;
	}
	
	/**
	 * Get fechaRespuesta
	 *
	 * @return \DateTime
	 */
	public function getFechaRespuesta()
	{
		return $this->fechaRespuestaInforme;
	}
			
	//------------------------------Propiedades Virtuales -------------------------------------
	
	/**
	 * Get fechaRespuestaFormateada
	 *
	 * @return string
	 *
	 * @VirtualProperty
	 */
	public function getFechaRespuestaFormateada()
	{
		return ((!is_null($this->getFechaRespuesta()))?$this->getFechaRespuesta()->format('d/m/Y'):'');
	}
	
}