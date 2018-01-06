<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * TipoSpeech
 * 
 * @ORM\Table(name="tipoSpeech")
 * @ORM\Entity()
 */
class TipoSpeech {

	//-----------------------------------------atributos de la clase-------------------------------
	
	/**
     * @var integer
     *
     * @ORM\Column(name="idTipoSpeech", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
	private $id;
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="tipoSpeech", type="string", length=15)
	 */
	private $tipoSpeech;
		
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
	 * Get tipoSpeech
	 * 
	 * @return string
	 */
	public function getTipoSpeech() {
		return $this->tipoSpeech;
	}
	
	/**
	 * Set tipoSpeech
	 * 
	 * @param string $tipoSpeech
	 * 
	 * @return \AppBundle\Entity\TipoSpeech
	 */
	public function setTipoSpeech($tipoSpeech) {
		$this->tipoSpeech = $tipoSpeech;
		return $this;
	}
}
