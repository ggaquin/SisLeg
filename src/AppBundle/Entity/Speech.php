<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Speech
 * 
 * @ORM\Table(name="speech")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpeechRepository")
 *
 */
class Speech {
	
	//-----------------------------------------atributos de la clase-------------------------------
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idSpeech", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="tituloSpeech", type="string", length=30, nullable=false)
	 */
	private $tituloSpeech;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="textoSuperior", type="string", length=1000)
	 */
	private $textoSuperior;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="textoInferior", type="string", length=1000)
	 */
	private $textoInferior;
	
	/**
	 * @var boolean
	 * 
	 * @ORM\Column(name="incluirSancion", type="boolean", nullable=false)
	 */
	private $incluirSancion;
	
	//-------------------------------------setters y getters--------------------------------------
	
	/**
	 * Get id
	 * 
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Get tituloSpeech
	 * 
	 * @return string
	 */
	public function getTituloSpeech() {
		return $this->tituloSpeech;
	}
	
	/**
	 * Set tituloSpeech
	 * 
	 * @param string $tituloSpeech
	 * @return Speech
	 */
	public function setTituloSpeech($tituloSpeech) {
		$this->tituloSpeech = $tituloSpeech;
		return $this;
	}
	
	/**
	 * Get textoSuperior
	 * 
	 * @return string
	 */
	public function getTextoSuperior() {
		return $this->textoSuperior;
	}
	
	/**
	 * Set textoSuperior
	 * 
	 * @param string $textoSuperior
	 * @return Speech
	 */
	public function setTextoSuperior($textoSuperior) {
		$this->textoSuperior = $textoSuperior;
		return $this;
	}
	
	/**
	 * Get textoInferior
	 * 
	 * @return string
	 */
	public function getTextoInferior() {
		return $this->textoInferior;
	}
	
	/**
	 * Set textoInferior
	 * 
	 * @param string $textoInferior
	 * @return Speech
	 */
	public function setTextoInferior($textoInferior) {
		$this->textoInferior = $textoInferior;
		return $this;
	}
	
	/**
	 * Get IncluirSancion
	 * 
	 * @return boolean
	 */
	public function getIncluirSancion() {
		return $this->incluirSancion;
	}
	
	/**
	 * Set incluirSancion
	 * 
	 * @param string $incluirSancion
	 * @return Speech
	 */
	public function setIncluirSancion($incluirSancion) {
		$this->incluirSancion = $incluirSancion;
		return $this;
	}
	
	/****************************Propiedades Virtuales**********************************/
	
	/**
	 * Get textoSpeech
	 * @VirtualProperty
	 * @return String
	 */
	public function getTextoSpeech(){
		
		$texto=(!is_null($this->getTextoSuperior())?$this->getTextoSuperior():'').
			   (($this->getIncluirSancion()==true)?'<p><strong>>>>></strong><u>TEXTO DE LA PRESENTE SANCIÓN</u><strong><<<<</strong></p>':'').
			   (!is_null($this->getTextoInferior())?$this->getTextoInferior():'');
		return $texto;
	}
	
}