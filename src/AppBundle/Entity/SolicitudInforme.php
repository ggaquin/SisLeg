<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * SolicitudInforme
 *
 * @ORM\Entity
 */

class SolicitudInforme extends Movimiento{
	
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
		
	//-----------------------------------setters y getters--------------------------------------
		
	/**
	 * Set sesion
	 *
	 * @param \AppBundle\Entity\Sesion $sesion
	 *
	 * @return SolicitudInforme
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
	 * Set fechaRespuesta
	 *
	 * @param \DateTime $fechaRespuesta
	 *
	 * @return SolicitidInforme
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
		return ((!is_null($this->fechaRespuesta))?$this->fechaRespuesta->format('d/m/Y'):'');
	}
	
}