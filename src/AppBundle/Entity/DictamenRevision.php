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
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\ProyectoRevision", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProyectoRevision",referencedColumnName="idProyectoRevision")
     * })
     */
    private $revisionProyecto;
		
	//-------------------------------------setters y getters------------------------------------
	
	
    /**
     * Set revisionProyecto
     *
     * @param \AppBundle\Entity\ProyectoRevision $revisionProyecto
     *
     * @return Dictamen
     */
    public function setRevisionProyecto(\AppBundle\Entity\ProyectoRevision $revisionProyecto= null)
    {
    	$this->revisionProyecto= $revisionProyecto;
    	
    	return $this;
    }
    
    /**
     * Get revisionProyecto
     *
     * @return \AppBundle\Entity\ProyectoRevision
     */
    public function getRevisionProyecto()
    {
    	return $this->revisionProyecto;
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
