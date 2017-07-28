<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoDictamen
 *
 * @ORM\Table(name="tipoDictamen")
 * @ORM\Entity()
 */
class TipoDictamen
{
	//-----------------------------------------atributos de la clase-------------------------------
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idTipoDictamen", type="smallint")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="tipoDictamen", type="string", length=15, nullable=false)
	 */
	private $tipoDictamen;
	
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
	 * Set tipoDictamen
	 *
	 * @param string $tipoDictamen
	 *
	 * @return TipoDictamen
	 */
	public function setTipoDictamen($tipoDictamen)
	{
		$this->tipoDictamen= $tipoDictamen;
		
		return $this;
	}
	
	/**
	 * Get $tipoDictamen
	 *
	 * @return string
	 */
	public function getTipoDictamen()
	{
		return $this->tipoDictamen;
	}
	
}
