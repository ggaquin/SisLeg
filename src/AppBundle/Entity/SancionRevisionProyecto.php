<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping\JoinTable;
use AppBundle\AppBundle;
use Doctrine\ORM\Mapping\Column;

/**
 * SancionRevisionProyecto
 * 
 * @ORM\Entity
 */
class SancionRevisionProyecto extends SancionTipada
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
     * @var \AppBundle\Entity\Pase
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Pase")
     * @ORM\JoinColumn(name="idPase", referencedColumnName="idMovimiento")
     */
    private $pase;
    
    /**
     * @var string
     * @Column(name="numeroSancion", type="string", length=9)
     */
    private $numeroSancion='';
        
    //------------------------------------constructor---------------------------------------------
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
    	$this->numeroSancion= "";
    }
    
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
     * @return SancionRevisionProyecto
     */
    public function setRevisionProyecto($revisionProyecto) {
    	$this->revisionProyecto = $revisionProyecto;
    	return $this;
    }
    
    /**
     * Get Pase
     *
     * @return \AppBundle\Entity\Pase
     */
    public function getPase() {
    	return $this->pase;
    }
    
    /**
     * Set Pase
     *
     * @param \AppBundle\Entity\Pase $pase
     *
     * @return SancionRevisionProyecto
     */
    public function setPase($pase) {
    	$this->pase = $pase;
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
     * @return SancionRevisionProyecto
     */
    public function setNumeroSancion($numeroSancion) {
    	$this->numeroSancion = $numeroSancion;
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
    	return "revision";
    }
      
}
