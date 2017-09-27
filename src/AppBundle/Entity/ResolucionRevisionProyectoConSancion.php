<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping\JoinTable;
use AppBundle\AppBundle;
use Doctrine\ORM\Mapping\Column;

/**
 * ResolucionRevisionProyectoConSancion
 * 
 * @ORM\Entity
 */
class ResolucionRevisionProyectoConSancion extends Resolucion
{
	// ------------------------------atributos de la clase-----------------------------------------
	
	 /**
     * @var \AppBundle\Entity\ProyectoRevision
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\ProyectoRevision", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProyectoRevision",referencedColumnName="idProyectoRevision")
     * })
     */
    private $revisionProyecto;
    
    /**
     * @var \AppBundle\Entity\Notificacion
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Notificacion", cascade={"persist"})
     * @ORM\JoinColumn(name="idNotificacion", referencedColumnName="idMovimiento")
     */
    private $notificacion;
    
    /**
     * @var string
     * @Column(name="numeroSancion", type="string", length=6)
     */
    private $numeroSancion='';
    
    //-------------------------------------setters y getters------------------------------------

   /**
    * Set revisionProyecto
    * 
    * @return ProyectoRevision
    */
    public function getRevisionProyecto() {
    	return $this->revisionProyecto;
    }
    
    /**
     * Set revisionProyecto
     * 
     * @param \AppBundle\Entity\ProyectoRevision $revisionProyecto
     * 
     * @return ResolucionRevisionProyectoConSancion
     */
    public function setRevisionProyecto($revisionProyecto) {
    	$this->revisionProyecto = $revisionProyecto;
    	return $this;
    }
    
    /**
     * Get notificacion
     * 
     * @return \AppBundle\Entity\Notificacion
     */
    public function getNotificacion() {
    	return $this->notificacion;
    }
		    
    /**
     * Set notificacion
     * 
     * @param \AppBundle\Entity\Notificacion $notificacion
     * 
     * @return ResolucionRevisionProyectoConSancion
     */
    public function setNotificacion($notificacion) {
    	$this->notificacion = $notificacion;
    	return $this;
    }
    
    /**
     * Get numeroSancion
     * 
     * @return string
     */
    public function getNumeroSancion() {
    	return $this->numeroSancion;
    }
    
    /**
     * Set numeroSancion
     * 
     * @param string $numeroSancion
     * 
     * @return ResolucionRevisionProyectoConSancion
     */
    public function setNumeroSancion($numeroSancion) {
    	$this->numeroSancion = $numeroSancion;
    	return $this;
    }
    
    //------------------------------Propiedades virtuales-----------------------------------------
    
    /**
     * get claseResolucion
     * 
     * @return string
     * @VirtualProperty()
     */
    public function getClaseResolucion(){
    	return "revisionProyecto";
    }
      
}
