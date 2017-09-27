<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping\JoinTable;
use AppBundle\AppBundle;
use Doctrine\ORM\Mapping\Column;

/**
 * ResolucionArticuladaConSancion
 * 
 * @ORM\Entity
 */
class ResolucionArticuladaConSancion extends Resolucion
{
	// ------------------------------atributos de la clase-----------------------------------------
	
	/**
	 *
	 * @var \AppBundle\Entity\TipoProyecto 
	 * 
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoProyecto")
	 * @ORM\JoinColumn(name="idTipoResolucion", referencedColumnName="idTipoProyecto")
	 */
	private $tipoResolucion;
	
	/**
	 * @var string
	 * @ORM\Column(name="textoArticulado",type="json_array",nullable=true)
	 */
    private $textoArticulado;
    
    /**
     * @var \AppBundle\Entity\Notificacion
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Notificacion")
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
     * Get tipoResolucion
     * 
     * @return \AppBundle\Entity\TipoProyecto
     */
    public function getTipoResolucion() {
    	return $this->tipoResolucion;
    }
    
    /**
     * Set tipoResolucion
     * 
     * @param \AppBundle\Entity\TipoProyecto $tipoResolucion
     * 
     * @return ResolucionArticuladaConSancion
     */
    public function setTipoResolucion($tipoResolucion) {
    	$this->tipoResolucion = $tipoResolucion;
    	return $this;
    }
    
    /**
     * Get textoArticulado
     * 
     * @return string
     */
    public function getTextoArticulado() {
    	return $this->textoArticulado;
    }
    
    /**
     * Set textoArticulado
     * 
     * @param string $textoArticulado
     * 
     * @return ResolucionArticuladaConSancion
     */
    public function setTextoArticulado($textoArticulado) {
    	$this->textoArticulado = $textoArticulado;
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
     * @return ResolucionArticuladaConSancion
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
     * @return ResolucionArticuladaConSancion
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
    	return "articulada";
    }
      
}
