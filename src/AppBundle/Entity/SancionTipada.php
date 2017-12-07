<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping\JoinTable;
use AppBundle\AppBundle;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;

/**
 * SancionTipada
 * 
 * @ORM\Entity()
 */
abstract class SancionTipada extends Sancion
{
	// ------------------------------atributos de la clase-----------------------------------------
	   
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Movimiento",cascade={"persist","merge","refresh"})
     * @ORM\JoinTable(name="sancion_notificacion",
     * 			      joinColumns={@ORM\JoinColumn(name="idSancion", referencedColumnName="idSancion")},
     * 			 	  inverseJoinColumns={@ORM\JoinColumn(name="idMovimiento", 
     * 													  referencedColumnName="idMovimiento",
     * 													  unique=true)}
     * 				  )
     */
    private $notificaciones;
        
    //------------------------------------constructor---------------------------------------------
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->notificaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    //-------------------------------------setters y getters------------------------------------

     
    /**
     * Add notificacion
     *
     * @param \AppBundle\Entity\Notificacion $notificacion
     *
     * @return SancionTipada
     */
    public function addNotificacion(\AppBundle\Entity\Notificacion $notificacion)
    {
    	$this->notificaciones[] = $notificacion;
    	
    	return $this;
    }
    
    /**
     * Remove notificacion
     *
     * @param \AppBundle\Entity\Notificacion $notificacion
     */
    public function removeNotificacion(\AppBundle\Entity\Notificacion $notificacion)
    {
    	$this->notificaciones->removeElement($notificacion);
    }
    
    /**
     * Get Notificaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotificaciones()
    {
    	return $this->notificaciones;
    }
    
    /**
     * Set notificaciones
     *
     * @param array $notificaciones
     *
     * @return SancionTipada
     */
    public function setNotificaciones($nuevasNotificaciones)
    {
    	$collection= new \Doctrine\Common\Collections\ArrayCollection();
    	foreach ($nuevasNotificaciones as $notifiicacion) {
    		$collection[]=$notifiicacion;
    	}
    	$this->notificaciones = $collection;
    }
        
    //------------------------------Propiedades virtuales-----------------------------------------
    
    /**
     * Get listaNotificaciones
     * 
     * @return array
     * @VirtualProperty()
     */
    public function getListaNotificaciones(){
    	
    	$listaNotificaciones=[];
    	
    	foreach ($this->notificaciones as $notificacionPersistida){
    		$oficina=$notificacionPersistida->getRemito()->getDestino();
    		$notificacion=array('id'=>$oficina->getId(),
    							'nombre'=>$oficina->getOficina()
    							);
    		$listaNotificaciones[]=$notificacion;
    	}
    	
    	return $listaNotificaciones;
    }
          
}
