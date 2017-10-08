<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * TipoPlantillaTexto
 * 
 * @ORM\Table(name="tipoPlantillaTexto")
 * @ORM\Entity()
 */
class TipoPlantillaTexto {

	//-----------------------------------------atributos de la clase-------------------------------
	
	/**
     * @var integer
     *
     * @ORM\Column(name="idTipoPlantillaTexto", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
	private $id;
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="tipoPlantillaTexto", type="string", length=15)
	 */
	private $tipoPlantillaTexto;
		
	//-------------------------------------setters y getters--------------------------------------
	
	/**
	 * Get id
	 * 
	 * @return integer
	 */	
	public function getId() {
		return $this->id;
	}
	
	/***
	 * Get tipoPlantillaTexto
	 * 
	 * @return string
	 */
	public function getTipoPlantillaTexto() {
		return $this->tipoPlantillaTexto;
	}
	
	/**
	 * Set tipoPlantillaTexto
	 * 
	 * @param string $tipoPlantillaTexto
	 * 
	 * @return \AppBundle\Entity\TipoPlantillaTexto
	 */
	public function setTipoPlantillaTexto($tipoPlantillaTexto) {
		$this->tipoPlantillaTexto = $tipoPlantillaTexto;
		return $this;
	}
}
