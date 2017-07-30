<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * DictamenArticulado
 * @ORM\Entity
 */
class DictamenArticulado extends Dictamen
{
    //------------------------------atributos de la clase-----------------------------------------
	
	/**
     * @var \AppBundle\Entity\TipoProyecto
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoProyecto", fetch="EAGER" )
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="idTipoDictamen", referencedColumnName="idTipoProyecto")
     * })
     */
    private $tipoDictamen;
	
	/**
	 * @var array
	 * @ORM\Column(name="textoArticulado", type="json_array", nullable=true)
	 */
	private $textoArticulado;
		
	//-------------------------------------setters y getters------------------------------------
	
	/**
	 * Get tipoDictamen
	 * 
	 * @return TipoProyecto
	 */
	public function getTipoDictamen() {
		return $this->tipoDictamen;
	}
	
	/**
	 * Set tipoDictamen
	 * 
	 * @param \AppBundle\Entity\TipoProyecto $tipoDictamen
	 * @return DictamenArticulado
	 */
	public function setTipoDictamen($tipoDictamen) {
		$this->tipoDictamen = $tipoDictamen;
		return $this;
	}
		
	/**
	 * Get textoArticulado
	 * 
	 * @return array
	 */
	public function getTextoArticulado() {
		return $this->textoArticulado;
	}
	
	/**
	 * Set textoArticulado
	 * 
	 * @param array $textoArticulado
	 * 
	 * @return DictamenArticulado
	 */
	public function setTextoArticulado($textoArticulado) {
		$this->textoArticulado = $textoArticulado;
		return $this;
	}
	
	//------------------------------Propiedades virtuales-----------------------------------------
	
	/**
	 * get claseDictamen
	 *
	 * @return string
	 * @VirtualProperty()
	 */
	public function getClaseDictamen(){
		return "articulado";
	}
		
}
