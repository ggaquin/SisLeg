<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Pase
 * 
 * @ORM\Entity
 */

class Pase extends Movimiento{
	
	/**
	 * @var int
	 *
	 * @ORM\Column(name="fojas", type="smallint", nullable=false)
	 */
	private $fojas;
	
	//-----------------------------------setters y getters--------------------------------------
	
	/**
	 * Set fojas
	 *
	 * @param integer $fojas
	 *
	 * @return Pase
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
		
}