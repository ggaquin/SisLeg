<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * SancionBasica
 * 
 * @ORM\Entity
 */
class SancionBasica extends Sancion
{
    //------------------------------atributos de la clase-----------------------------------------
       
    /**
     * @var string
     * @ORM\Column(name="textoLibre",type="text",nullable=true)
     */
    private $textoLibre;
    
    //-------------------------------------setters y getters------------------------------------
	
	/**
	 * Get textoLibre
	 *
	 * @return string
	 */
	public function getTextoLibre() {
		return $this->textoLibre;
	}
	
	/**
	 * Set textoLibre
	 *
	 * @param string $textoLibre
	 *
	 * @return Sancion
	 */
	public function setTextoLibre($textoLibre) {
		$this->textoLibre = $textoLibre;
		return $this;
	}
	    
    //------------------------------Propiedades virtuales-----------------------------------------
    
    /**
     * get claseSancion
     * 
     * @return string
     * @VirtualProperty()
     */
    public function getClaseSancion(){
    	return "basico";
    }
      
}
