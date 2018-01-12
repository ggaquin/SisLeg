<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoNumeroDictamen
 *
 * @ORM\Table(name="tipoNumeroDictamen")
 * @ORM\Entity()
 */
class TipoNumeroDictamen
{
	//-----------------------------------------atributos de la clase-------------------------------
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idTipoNumeroDictamen", type="smallint")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="tipoNumeroDictamen", type="string", length=15, nullable=false)
	 */
	private $tipoNumeroDictamen;
	
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
	 * Set tipoNumeroDictamen
	 *
	 * @param string $tipoNumeroDictamen
	 *
	 * @return TipoNumeroDictamen
	 */
	public function setTipoNumeroDictamen($tipoNumeroDictamen)
	{
		$this->tipoNumeroDictamen= $tipoNumeroDictamen;
		
		return $this;
	}
	
	/**
	 * Get $tipoNumeroDictamen
	 *
	 * @return string
	 */
	public function getTipoNumeroDictamen()
	{
		return $this->tipoNumeroDictamen;
	}
	
}
