<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\Column;

/**
 * Dictamen
 * 
 * @ORM\Table(name="dictamen",  indexes={@ORM\Index(name="dictamen_proyectoRevision_idx",columns={"idProyectoRevision"}),
 * 										 @ORM\Index(name="dictamen_tipoProyecto_idx",columns={"idTipoDictamen"})
 * 										})
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminador", type="string", length=15)
 * @ORM\DiscriminatorMap({"basico" = "AppBundle\Entity\Dictamen", 
 *                        "articulado" = "AppBundle\Entity\DictamenArticulado",
 *                        "revision" = "AppBundle\Entity\DictamenRevision"})
 */
class Dictamen
{
    //------------------------------atributos de la clase-----------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idDictamen", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
        
    /**
     * @var string
     * @ORM\Column(name="textoLibre",type="text",nullable=false)
     */
    private $textoLibre;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PerfilLegislador", orphanRemoval=true)
     * @JoinTable(name="dictamen_legislador",
     * 			 joinColumns={@ORM\JoinColumn(name="idDictamen", referencedColumnName="idDictamen")},
     * 			 inverseJoinColumns={@ORM\JoinColumn(name="idPerfil", referencedColumnName="idPerfil")}
     * 			 )
     */
    private $concejales;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ExpedienteComision", 
     * 				  cascade={"persist","merge","refresh"}, mappedBy="dictamenMayoria")
     */
    private $asignacionesPorMayoria;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ExpedienteComision", 
     * 				   cascade={"persist","merge","refresh"}, 
     * 				  mappedBy="dictamenMayoriaQueAgrega")
     */
    private $expedientesAgregadosDictamenMayoria;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ExpedienteComision", 
     * 				  cascade={"persist","merge","refresh"}, mappedBy="dictamenPrimeraMinoria")
     */	
    private $asignacionesPorPrimeraMinoria;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\oneToMany(targetEntity="AppBundle\Entity\ExpedienteComision", 
     * 				    cascade={"persist","merge","refresh"}, 
     * 					mappedBy="dictamenPrimeraMinoriaQueAgrega")
     */
    private $expedientesAgregadosDictamenPrimeraMinoria;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ExpedienteComision",
     * 				  cascade={"persist","merge","refresh"}, mappedBy="dictamenSegundaMinoria")
     */
    private $asignacionesPorSegundaMinoria;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\oneToMany(targetEntity="AppBundle\Entity\ExpedienteComision",
     * 				  cascade={"persist","merge","refresh"}, 
     * 				 mappedBy="dictamenSegundaMinoriaQueAgrega")
     */
    private $expedientesAgregadosDictamenSegundaMinoria;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="ultimoMomento", type="boolean", nullable=false)
     */
    private $ultimoMomento;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="invalidadoPorAgregacion",type="boolean", nullable=false)
     */
   	private $invalidadoPorAgregacion; 
        	
    /**
     * @var string
     *
     * @ORM\Column(name="usuarioCreacion", length=70, type="string", nullable=false)
     */
    private $usuarioCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="usuarioModificacion", length=70, type="string", nullable=true)
     */
    private $usuarioModificacion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificacion", type="datetime", nullable=true)
     */
    private $fechaModificacion;
    
    
    //------------------------------------constructor---------------------------------------------
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->concejales = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->asignacionesPorMayoria = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->asignacionesPorPrimeraMinoria = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->asignacionesPorSegundaMinoria = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->expedientesAgregadosDictamenMayoria=new \Doctrine\Common\Collections\ArrayCollection();
    	$this->expedientesAgregadosDictamenPrimeraMinoria=new \Doctrine\Common\Collections\ArrayCollection();
    	$this->expedientesAgregadosDictamenSegundaMinoria=new \Doctrine\Common\Collections\ArrayCollection();
    	$this->ultimoMomento=false;
    	$this->invalidadoPorAgregacion=false;
     	
    }

    //-------------------------------------setters y getters------------------------------------

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
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
     * @return Dictamen
     */
    public function setTextoLibre($textoLibre) {
    	$this->textoLibre = $textoLibre;
    	return $this;
    }
    
    /**
     * set concejales
     *
     * @param array $nuevosConcejales
     *
     * @return Dictamen
     */
    public function setConcejales($nuevosConcejales)
    {
    	$collection= new \Doctrine\Common\Collections\ArrayCollection();
    	foreach ($nuevosConcejales as $concejal) {
    		$collection[]=$concejal;
    	}
    	$this->concejales = $collection;
    	
    	return $this;
    }
    
    /**
     * Add concejal
     *
     * @param \AppBundle\Entity\Perfil $concejal
     *
     * @return Dictamen
     */
    public function addConcejal(\AppBundle\Entity\PerfilLegislador $concejal)
    {
    	$this->concejales[] = $concejal;
    	
    	return $this;
    }
    
    /**
     * Remove concejal
     *
     * @param \AppBundle\Entity\PerfilLegislador $concejal
     *
     * @return Dictamen
     */
    public function removeConcejal(\AppBundle\Entity\PerfilLegislador $concejal)
    {
    	$this->concejales->removeElement($concejal);
    	return $this;
    }
    
    /**
     * Get concejales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConcejales()
    {
    	return $this->concejales;
    }
   
    /**
     * set asignacionesPorMayoria
     *
     * @param array $asignacionesPorMayoria
     *
     * @return Dictamen
     */
    public function setAsignacionesPorMayoria($asignacionesPorMayoria)
    {
    	$collection= new \Doctrine\Common\Collections\ArrayCollection();
    	foreach ($asignacionesPorMayoria as $asignacionPorMayoria) {
    		$asignacionPorMayoria->setDictamenMayoria($this);
    		$collection[]=$asignacionPorMayoria;
    	}
    	$this->asignacionesPorMayoria = $collection;
    	
    	return $this;
    }
    
    /**
     * Add asignacionPorMayoria
     *
     * @param \AppBundle\Entity\ExpedienteComision $asignacionPorMayoria
     *
     * @return Dictamen
     */
    public function addAsignacionPorMayoria(\AppBundle\Entity\ExpedienteComision $asignacionPorMayoria)
    {
    	$asignacionPorMayoria->setDictamenMayoria($this);
    	$this->asignacionesPorMayoria[] = $asignacionPorMayoria;
    	return $this;
    }
    
    /**
     * Remove asignacionPorMayoria
     *
     * @param \AppBundle\Entity\ExpedienteComision $asignacionPorMayoria
     *
     * @return Dictamen
     */
    public function removeAsignacionPorMayoria(\AppBundle\Entity\ExpedienteComision $asignacionPorMayoria)
    {
    	$this->asignacionesPorMayoria->removeElement($asignacionPorMayoria);
    	return $this;
    }
    
    /**
     * Get asignacionesPorMayoria
     *
     * @return \Doctrine\Common\Collections\Collection
     * 
     * @Exclude()
     */
    public function getAsignacionesPorMayoria()
    {
    	return $this->asignacionesPorMayoria;
    }
    
    /**
     * Get expedientesAgregadosDictamenMayoria
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
	public function getExpedientesAgregadosDictamenMayoria() {
		return $this->expedientesAgregadosDictamenMayoria;
	}
	
	/**
	 * Add expedienteAgregadoDictamenMayoria
	 *
	 * @param \AppBundle\Entity\ExpedienteComision $expedienteAgregadoDictamenMayoria
	 *
	 * @return Dictamen
	 */
	public function addExpedienteAgregadoDictamenMayoria(\AppBundle\Entity\ExpedienteComision $expedienteAgregadoDictamenMayoria)
	{
		$expedienteAgregadoDictamenMayoria->setDictamenMayoriaQueAgrega($this);
		$this->expedientesAgregadosDictamenMayoria[] = $expedienteAgregadoDictamenMayoria;
		return $this;
	}
	
	/**
	 * Remove expedienteAgregadoDictamenMayoria
	 *
	 * @param \AppBundle\Entity\ExpedienteComision $expedienteAgregadoDictamenMayoria
	 *
	 * @return Dictamen
	 */
	public function removeExpedienteAgregadoDictamenMayoria(\AppBundle\Entity\ExpedienteComision $expedienteAgregadoDictamenMayoria)
	{
		$this->expedientesAgregadosDictamenMayoria->removeElement($expedienteAgregadoDictamenMayoria);
		return $this;
	}
	
	/**
	 * Set expedientesAgregadosDictamenMayoria
	 * 
	 * @param \Doctrine\Common\Collections\Collection $expedientesAgregadosDictamenMayoria
	 * @return Dictamen
	 */
	public function setExpedientesAgregadosDictamenMayoria($expedientesAgregadosDictamenMayoria) {
		
		$collection= new \Doctrine\Common\Collections\ArrayCollection();
		foreach ($expedientesAgregadosDictamenMayoria as $expedienteAgregadoDictamenMayoria) {
			$expedienteAgregadoDictamenMayoria->setDictamenMayoria($this);
			$collection[]=$expedienteAgregadoDictamenMayoria;
		}
		$this->asignacionesPorMayoria = $collection;
		
		return $this;
	}
	   
    /**
     * set asignacionesPorPrimeraMinoria
     *
     * @param array $asignacionesPorPrimeraMinoria
     *
     * @return Dictamen
     */
    public function setAsignacionesPorPrimeraMinoria($asignacionesPorPrimeraMinoria)
    {
    	$collection= new \Doctrine\Common\Collections\ArrayCollection();
    	foreach ($asignacionesPorPrimeraMinoria as $asignacionPorPrimeraMinoria) {
    		$asignacionPorPrimeraMinoria->setDictamenPrimeraMinoria($this);
    		$collection[]=$asignacionPorPrimeraMinoria;
    	}
    	$this->asignacionesPorPrimeraMinoria = $collection;
    	
    	return $this;
    }
    
    /**
     * Add asignacionPorPrimeraMinoria
     *
     * @param \AppBundle\Entity\ExpedienteComision $asignacionPorPrimeraMinoria
     *
     * @return Dictamen
     */
    public function addAsignacionPorPrimeraMinoria(\AppBundle\Entity\ExpedienteComision $asignacionPorPrimeraMinoria)
    {
    	$asignacionPorPrimeraMinoria->setDictamenPrimeraMinoria($this);
    	$this->asignacionesPorPrimeraMinoria[] = $asignacionPorPrimeraMinoria;
    	return $this;
    }
    
    /**
     * Remove asignacionPorPrimeraMinoria
     *
     * @param \AppBundle\Entity\ExpedienteComision $asignacionPorPrimeraMinoria
     *
     * @return Dictamen
     */
    public function removeAsignacionPorPrimeraMinoria(\AppBundle\Entity\ExpedienteComision $asignacionPorPrimeraMinoria)
    {	
    	$this->asignacionesPorPrimeraMinoria->removeElement($asignacionPorPrimeraMinoria);
    	return $this;
    }
    
    /**
     * Get asignacionesPorPrimeraMinoria
     *
     * @return \Doctrine\Common\Collections\Collection
     * 
     * @Exclude()
     */
    public function getAsignacionesPorPrimeraMinoria()
    {
    	return $this->asignacionesPorPrimeraMinoria;
    }
    
    /**
     * Get expedientesAgregadosDictamenPrimeraMinoria
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
	public function getExpedientesAgregadosDictamenPrimeraMinoria() {
		return $this->expedientesAgregadosDictamenPrimeraMinoria;
	}
	
	/**
	 * Add expedienteAgregadoDictamenPrimeraMinoria
	 *
	 * @param \AppBundle\Entity\ExpedienteComision $expedienteAgregadoDictamenPrimeraMinoria
	 *
	 * @return Dictamen
	 */
	public function addExpedienteAgregadoDictamenPrimeraMinoria(\AppBundle\Entity\ExpedienteComision $expedienteAgregadoDictamenPrimeraMinoria)
	{
		$expedienteAgregadoDictamenPrimeraMinoria->setDictamenPrimeraMinoriaQueAgrega($this);
		$this->asignacionesPorPrimeraMinoria[] = $expedienteAgregadoDictamenPrimeraMinoria;
		return $this;
	}
	
	/**
	 * Remove expedienteAgregadoDictamenPrimeraMinoria
	 *
	 * @param \AppBundle\Entity\ExpedienteComision $expedienteAgregadoDictamenPrimeraMinoria
	 *
	 * @return Dictamen
	 */
	public function removeExpedienteAgregadoDictamenPrimeraMinoria(\AppBundle\Entity\ExpedienteComision $expedienteAgregadoDictamenPrimeraMinoria)
	{
		$this->expedientesAgregadosDictamenPrimeraMinoria->removeElement($expedienteAgregadoDictamenPrimeraMinoria);
		return $this;
	}
	
	/**
	 * Set expedientesAgregadosDictamenPrimeraMinoria
	 * 
	 * @param \Doctrine\Common\Collections\Collection $expedientesAgregadosDictamenPrimeraMinoria
	 * @return Dictamen
	 */
	public function setExpedientesAgregadosDictamenPrimeraMinoria($expedientesAgregadosDictamenPrimeraMinoria) {
		
		$collection= new \Doctrine\Common\Collections\ArrayCollection();
		foreach ($expedientesAgregadosDictamenPrimeraMinoria as $expedienteAgregadoDictamenPrimeraMinoria) {
			$expedienteAgregadoDictamenPrimeraMinoria->setDictamenMayoria($this);
			$collection[]=$expedienteAgregadoDictamenPrimeraMinoria;
		}
		$this->expedientesAgregadosDictamenPrimeraMinoria = $collection;
		
		return $this;
	}
	    
    /**
     * set asignacionesPorSegundaMinoria
     *
     * @param array $asignacionesPorSegundaMinoria
     *
     * @return Dictamen
     */
    public function setAsignacionesPorSegundaMinoria($asignacionesPorSegundaMinoria)
    {
    	$collection= new \Doctrine\Common\Collections\ArrayCollection();
    	foreach ($asignacionesPorSegundaMinoria as $asignacionPorSegundaMinoria) {
    		$asignacionesPorSegundaMinoria->setDictamenSegundaMinoria($this);
    		$collection[]=$asignacionPorSegundaMinoria;
    	}
    	$this->asignacionesPorSegundaMinoria = $collection;
    	
    	return $this;
    }
  
    /**
     * Add asignacionPorSegundaMinoria
     *
     * @param \AppBundle\Entity\ExpedienteComision $asignacionPorSegundaMinoria
     *
     * @return Dictamen
     */
    public function addAsignacionPorSegundaMinoria(\AppBundle\Entity\ExpedienteComision $asignacionPorSegundaMinoria)
    {
    	$asignacionPorSegundaMinoria->setDictamenSegundaMinoria($this);
    	$this->asignacionesPorSegundaMinoria[] = $asignacionPorSegundaMinoria;
    	return $this;
    }
    
    /**
     * Remove asignacionPorSegundaMinoria
     *
     * @param \AppBundle\Entity\ExpedienteComision $asignacionPorSegundaMinoria
     *
     * @return Dictamen
     */
    public function removeAsignacionPorSegundaMinoria(\AppBundle\Entity\ExpedienteComision $asignacionPorSegundaMinoria)
    {
    	$this->asignacionesPorSegundaMinoria->removeElement($asignacionPorSegundaMinoria);
    	return $this;
    }
    
    /**
     * Get asignacionesPorSegundaMinoria
     *
     * @return \Doctrine\Common\Collections\Collection
     * @Exclude()
     */
    public function getAsignacionesPorSegundaMinoria()
    {
    	return $this->asignacionesPorSegundaMinoria;
    }
    
    /**
     * Get expedientesAgregadosDictamenSegundaMinoria
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
	public function getExpedientesAgregadosDictamenSegundaMinoria() {
		return $this->expedientesAgregadosDictamenSegundaMinoria;
	}
	
	/**
	 * Add expedienteAgregadoDictamenSegundaMinoria
	 *
	 * @param \AppBundle\Entity\ExpedienteComision $expedienteAgregadoDictamenSegundaMinoria
	 *
	 * @return Dictamen
	 */
	public function addExpedientesAgregadosDictamenSegundaMinoria(\AppBundle\Entity\ExpedienteComision $expedienteAgregadoDictamenSegundaMinoria)
	{
		$expedienteAgregadoDictamenSegundaMinoria($this);
		$this->expedientesAgregadosDictamenSegundaMinoria = $expedienteAgregadoDictamenSegundaMinoria;
		return $this;
	}
	
	/**
	 * Remove expedienteAgregadoDictamenSegundaMinoria
	 *
	 * @param \AppBundle\Entity\ExpedienteComision $expedienteAgregadoDictamenSegundaMinoria
	 *
	 * @return Dictamen
	 */
	public function removeExpedienteAgregadoDictamenSegundaMinoria(\AppBundle\Entity\ExpedienteComision $expedienteAgregadoDictamenSegundaMinoria)
	{
		$this->expedientesAgregadosDictamenSegundaMinoria->removeElement($expedienteAgregadoDictamenSegundaMinoria);
		return $this;
	}
	
	/**
	 * Set expedientesAgregadosDictamenSegundaMinoria
	 * 
	 * @param \Doctrine\Common\Collections\Collection $expedientesAgregadosDictamenSegundaMinoria
	 * @return Dictamen
	 */
	public function setExpedientesAgregadosDictamenSegundaMinoria($expedientesAgregadosDictamenSegundaMinoria) {
		
		$collection= new \Doctrine\Common\Collections\ArrayCollection();
		foreach ($expedientesAgregadosDictamenSegundaMinoria as $expedienteAgregadoDictamenSegundaMinoria) {
			$expedienteAgregadoDictamenSegundaMinoria->setDictamenSegundaMinoriaQueAgrega($this);
			$collection[]=$expedienteAgregadoDictamenSegundaMinoria;
		}
		$this->expedientesAgregadosDictamenSegundaMinoria = $collection;
		
		return $this;
	}
	    
    /**
     * Get ultimoMomento
     * @return boolean
     */
	public function getUltimoMomento() {
		return $this->ultimoMomento;
	}
	
	/**
	 * Set UltimoMomento
	 * 
	 * @param boolean $ultimoMomento
	 * 
	 * @return \AppBundle\Entity\Dictamen
	 */
	public function setUltimoMomento($ultimoMomento) {
		$this->ultimoMomento = $ultimoMomento;
		return $this;
	}
	
	/**
	 * Get invalidadoPorAgregacion
	 * 
	 * @return boolean
	 */
	public function getInvalidadoPorAgregacion() {
		return $this->invalidadoPorAgregacion;
	}
	
	/**
	 * Set invalidadoPorAgregacion
	 * 
	 * @param boolean $invalidadoPorAgregacion
	 * @return Dictamen
	 */
	public function setInvalidadoPorAgregacion($invalidadoPorAgregacion) {
		$this->invalidadoPorAgregacion = $invalidadoPorAgregacion;
		return $this;
	}
				    
    /**
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     *
     * @return Dictamen
     */
    public function setUsuarioCreacion($usuarioCreacion)
    {
        $this->usuarioCreacion = $usuarioCreacion;

        return $this;
    }

    /**
     * Get usuarioCreacion
     *
     * @return string
     */
    public function getUsuarioCreacion()
    {
        return $this->usuarioCreacion;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Dictamen
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }
    
    /**
     * Get usuarioModificacion
     * @return string
     */
	public function getUsuarioModificacion() {
		return $this->usuarioModificacion;
	}
	
	/**
	 * Set usuarioModificacion
	 * 
	 * @param string $usuarioModificacion
	 * 
	 * @return Dictamen
	 */
	public function setUsuarioModificacion($usuarioModificacion) {
		$this->usuarioModificacion = $usuarioModificacion;
		return $this;
	}
	
	/**
	 * Get fechaModificacion
	 * 
	 * @return \DateTime
	 */
	public function getFechaModificacion() {
		return $this->fechaModificacion;
	}
	
	/**
	 * Set fechaModifiicacion
	 * 
	 * @param \DateTime $fechaModificacion
	 * 
	 * @return Dictamen
	 */
	public function setFechaModificacion(\DateTime $fechaModificacion) {
		$this->fechaModificacion = $fechaModificacion;
		return $this;
	}
	    
    
    /**
     * Get tieneAsignaciones
     * 
     * @return boolean
     */
    public function getTieneAsignaciones()
    {
    	return (count($this->asignacionesPorMayoria)>0 ||
    			count($this->asignacionesPorPrimeraMinoria)>0 ||
    			count($this->asignacionesPorSegundaMinoria)>0);
    }

    //------------------------------Propiedades virtuales-----------------------------------------
    
    /**
     * get claseDictamen
     * 
     * @return string
     * @VirtualProperty()
     */
    public function getClaseDictamen(){
    	return "basico";
    }
           
    /**
     * get listaComisionesMayoria
     *
     * @return string
     * @VirtualProperty()
     */
    public function getListaComisionesMayoria(){
    	$comisiones="";
    	$asinaciones=$this->asignacionesPorMayoria;
    	foreach ($asinaciones as $asinacion)
    		$comisiones.=(($comisiones!="")?'/':'').$asinacion->getComision()->getComision();
    	return $comisiones;
    }
    
    /**
     * get listaLetrasComisionesMayoria
     *
     * @return string
     * @VirtualProperty()
     */
    public function getListaLetrasComisionesMayoria(){
    	$comisiones="";
    	$asinaciones=$this->asignacionesPorMayoria;
    	foreach ($asinaciones as $asinacion)
    		$comisiones.=(($comisiones!="")?'-':'').$asinacion->getComision()->getLetraOrdenDelDia();
    		return $comisiones;
    }
    
    /**
     * get listaComisionesPrimeraMinoria
     *
     * @return string
     * @VirtualProperty()
     */
    public function getListaComisionesPrimeraMinoria(){
    	$comisiones="";
    	$asinaciones=$this->asignacionesPorPrimeraMinoria;
    	foreach ($asinaciones as $asinacion)
    		$comisiones.=(($comisiones!="")?'/':'').$asinacion->getComision()->getComision();
    		return $comisiones;
    }
    
    /**
     * get listaLetrasComisionesPrimeraMinoria
     *
     * @return string
     * @VirtualProperty()
     */
    public function getListaLetrasComisionesPrimeraMinoria(){
    	$comisiones="";
    	$asinaciones=$this->asignacionesPorPrimeraMinoria;
    	foreach ($asinaciones as $asinacion)
    		$comisiones.=(($comisiones!="")?'-':'').$asinacion->getComision()->getLetraOrdenDelDia();
    		return $comisiones;
    }
    
    /**
     * get listaComisionesSegundaMinoria
     *
     * @return string
     * @VirtualProperty()
     */
    public function getListaComisionesSegundaMinoria(){
    	$comisiones="";
    	$asinaciones=$this->asignacionesPorSegundaMinoria;
    	foreach ($asinaciones as $asinacion)
    		$comisiones.=(($comisiones!="")?'-':'').$asinacion->getComision()->getComision();
    		return $comisiones;
    }
    
    /**
     * get listaLetrasComisionesSegundaMinoria
     *
     * @return string
     * @VirtualProperty()
     */
    public function getListaLetrasComisionesSegundaMinoria(){
    	$comisiones="";
    	$asinaciones=$this->asignacionesPorSegundaMinoria;
    	foreach ($asinaciones as $asinacion)
    		$comisiones.=(($comisiones!="")?'-':'').$asinacion->getComision()->getLetraOrdenDelDia();
    		return $comisiones;
    }
    
    /**
     * get listaAgregados
     *
     * @return array
     * @VirtualProperty()
     */
    public function getListaAgregados(){
    	
    	$agregados=null;
    	$listaRetorno=[];
    	
    	if(count($this->expedientesAgregadosDictamenMayoria)>0)
    		$agregados=$this->expedientesAgregadosDictamenMayoria;
    	
    	if(count($this->expedientesAgregadosDictamenPrimeraMinoria)>0)
    		$agregados=$this->expedientesAgregadosDictamenPrimeraMinoria;
    		
    	if(count($this->expedientesAgregadosDictamenSegundaMinoria)>0)
    		$agregados=$this->expedientesAgregadosDictamenSegundaMinoria;
    	
    	foreach ($agregados as $agregado){
	    	$expediente=array(
			    				'numeroCompleto'=>$agregado->getExpediente()->getNumeroCompleto(),
			    				'id'=>$agregado->getExpediente()->getId()	
			    			 );
    		$listaRetorno[]=$expediente;
    	}
    	
    	return $listaRetorno;   	
    	
    }
  
}
