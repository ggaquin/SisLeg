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
 * SancionArticulada
 * 
 * @ORM\Entity
 */
class SancionArticulada extends SancionTipada
{
	// ------------------------------atributos de la clase-----------------------------------------
	
	/**
	 *
	 * @var \AppBundle\Entity\TipoProyecto 
	 * 
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoProyecto")
	 * @ORM\JoinColumn(name="idTipoSancion", referencedColumnName="idTipoProyecto")
	 */
	private $tipoSancion;
	
	/**
	 * @var array
	 * @ORM\Column(name="textoArticulado",type="json_array",nullable=true)
	 */
    private $textoArticulado;
    
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
     * Get tipoSancion
     * 
     * @return \AppBundle\Entity\TipoProyecto
     */
    public function getTipoSancion() {
    	return $this->tipoSancion;
    }
    
    /**
     * Set tipoSancion
     * 
     * @param \AppBundle\Entity\TipoProyecto $tipoSancion
     * 
     * @return SancionArticulada
     */
    public function setTipoSancion($tipoSancion) {
    	$this->tipoSancion = $tipoSancion;
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
     * @return SancionArticulada
     */
    public function setTextoArticulado($textoArticulado) {
    	$this->textoArticulado = $textoArticulado;
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
     * @return SancionArticulada
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
     * @return SancionArticulada
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
    	return "articulado";
    }
      
}
