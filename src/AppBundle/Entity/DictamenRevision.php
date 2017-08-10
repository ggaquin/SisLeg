<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * DictamenRevision
 * @ORM\Entity
 */
class DictamenRevision extends Dictamen
{
    //------------------------------atributos de la clase-----------------------------------------
	
	 /**
     * @var \AppBundle\Entity\ProyectoRevision
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\ProyectoRevision")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProyectoRevision",referencedColumnName="idProyectoRevision")
     * })
     */
    private $revisionProyecto;
		
	//-------------------------------------setters y getters------------------------------------
	
	
    /**
     * Set revisionDictamen
     *
     * @param \AppBundle\Entity\ProyectoRevision $proyectoRevision
     *
     * @return Dictamen
     */
    public function setRevisionProyecto(\AppBundle\Entity\ProyectoRevision $proyectoRevision= null)
    {
    	$this->revisionDictamen= $proyectoRevision;
    	
    	return $this;
    }
    
    /**
     * Get revisionDictamen
     *
     * @return \AppBundle\Entity\ProyectoRevision
     */
    public function getRevisionProyecto()
    {
    	return $this->revisionDictamen;
    }
	
	//------------------------------Propiedades virtuales-----------------------------------------
	
	/**
	 * Get claseDictamen
	 *
	 * @return string
	 * @VirtualProperty()
	 */
	public function getClaseDictamen(){
		return "revision";
	}
	
	/**
	 * Get tipoDictamen
	 * 
	 * @return TipoProyecto
	 * @VirtualProperty()
	 */
	public function getTipoDictamen(){
		return $this->revisionProyecto->getProyecto()->getTipoProyecto();
	}
}
