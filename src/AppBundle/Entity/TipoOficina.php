<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoOficina
 *
 * @ORM\Table(name="tipoOficina")
 * @ORM\Entity()
 */
class TipoOficina
{
	//-----------------------------------------atributos de la clase-------------------------------
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idTipoOficina", type="smallint")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="tipoOficina", type="string", length=15, nullable=false)
	 */
	private $tipoOficina;
	
	//-------------------------------------setters y getters--------------------------------------
	
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Set tipoOficina
	 *
	 * @param string $tipoOficina
	 *
	 * @return TipoOficina
	 */
	public function setTipoOficina($tipoOficina)
	{
		$this->tipoOficina= $tipoOficina;
		
		return $this;
	}
	
	/**
	 * Get tipoOficina
	 *
	 * @return string
	 */
	public function getTipoOficina()
	{
		return $this->tipoOficina;
	}
	
}
