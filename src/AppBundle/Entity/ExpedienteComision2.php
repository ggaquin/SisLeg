<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use AppBundle\AppBundle;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * ExpedienteComision
 *
 * @ORM\Table(name="expedienteComision", indexes={@ORM\Index(name="expedienteComision_expediente_idx", columns={"idExpediente"}), 
 *                                                @ORM\Index(name="expedienteComision_comision_idx", columns={"idComision"}),
 *                                                @ORM\Index(name="expedienteComision_movimiento_idx", columns={"idMovimiento"}),
 *                                                @ORM\Index(name="expedienteComision_sesion_idx", columns={"idSesion"}),
 *                                                @ORM\Index(name="expedienteComision_dictamenMayoria_idx", columns={"idDictamenMayoria"}),
 *                                                @ORM\Index(name="expedienteComision_dictamenPrimeraMinoria_idx", columns={"idDictamenPrimeraMinoria"}),
 *                                                @ORM\Index(name="expedienteComision_dictamenSegundaMinoria_idx", columns={"idDictamenSegundaMinoria"}),
 *                                                @ORM\Index(name="expedienteComision_dictamenMayoriaQueAgrega_idx", columns={"idDictamenMayoriaQueAgrega"}),
 *                                                @ORM\Index(name="expedienteComision_dictamenPrimeraMinoriaQueAgrega_idx", columns={"idDictamenPrimeraMinoriaQueAgrega"}),
 *                                                @ORM\Index(name="expedienteComision_dictamenSegundaMinoriaQueAgrega_idx", columns={"idDictamenSegundaMinoriaQueAgrega"})
 *                                               })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExpedienteComisionRepository")
 */
class ExpedienteComision
{
    //------------------------------atributos de la clase-----------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idExpedienteComision", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var \AppBundle\Entity\Sesion
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sesion")
     * @ORM\JoinColumn(name="idSesion", referencedColumnName="idSesion")
     */
    private $sesion;
 
   /**
     * @var \AppBundle\Entity\Expediente
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Expediente", inversedBy="asignacionComisiones", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idExpediente", referencedColumnName="idExpediente")
     * })
     */
    private $expediente;

   /**
     * @var \AppBundle\Entity\Comision
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Comision", inversedBy="expedientesAsignados")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idComision", referencedColumnName="idComision")
     * })
     */
    private $comision;
    
     /**
     *  @var \AppBundle\Entity\Dictamen
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dictamen", inversedBy="asignacionesPorMayoria")
     * @ORM\JoinColumn(name="idDictamenMayoria", referencedColumnName="idDictamen")
     */
    private $dictamenMayoria;
    
    /**
     * @var \AppBundle\Entity\Dictamen
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Dictamen", inversedBy="expedientesAgregadosDictamenMayoria")
     * @ORM\JoinColumn(name="idDictamenMayoriaQueAgrega", referencedColumnName="idDictamen")
     */
    private $dictamenMayoriaQueAgrega;
    
    /**
     *  @var \AppBundle\Entity\Dictamen
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dictamen", inversedBy="asignacionesPorPrimeraMinoria")
     * @ORM\JoinColumn(name="idDictamenPrimeraMinoria", referencedColumnName="idDictamen")
     */
    private $dictamenPrimeraMinoria;
    
    /**
     * @var \AppBundle\Entity\Dictamen
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Dictamen", inversedBy="expedientesAgregadosDictamenPrimeraMinoria")
     * @ORM\JoinColumn(name="idDictamenPrimeraMinoriaQueAgrega", referencedColumnName="idDictamen")
     */
    private $dictamenPrimeraMinoriaQueAgrega;
    
    /**
     *  @var \AppBundle\Entity\Dictamen
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dictamen", inversedBy="asignacionesPorSegundaMinoria")
     * @ORM\JoinColumn(name="idDictamenSegundaMinoria", referencedColumnName="idDictamen")
     */
    private $dictamenSegundaMinoria;
    
    /**
     * @var \AppBundle\Entity\Dictamen
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Dictamen", inversedBy="expedientesAgregadosDictamenSegundaMinoria")
     * @ORM\JoinColumn(name="idDictamenSegundaMinoriaQueAgrega", referencedColumnName="idDictamen")
     */
    private $dictamenSegundaMinoriaQueAgrega;
        
    /**
     * @var boolean
     * @ORM\Column(name="anulado", type="boolean", nullable=false)
     */
    private $anulado;
    
    /**
     *@var \AppBundle\Entity\Pase
     *
     * @ORM\manyToOne(targetEntity="AppBundle\Entity\Pase")
     * @ORM\JoinColumns({
     * 		@ORM\JoinColumn(name="idMovimiento", referencedColumnName="idMovimiento")
     * })
     */
    private $paseOriginario;
        
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="usuarioCreacion", type="string", length=70, nullable=false)
     */
    private $usuarioCreacion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificacion", type="datetime", nullable=true)
     */
    private $fechaModificacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="usuarioModificacion", type="string", length=70, nullable=true)
     */
    private $usuarioModificacion;
    
    //------------------------------------constructor---------------------------------------------
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->fechaCreacion=new \DateTime("now");
    	$this->anulado=false;
    }

    //--------------------------------------setters y getters----------------------------------------

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
     * Get sesion
     * 
     * @return \AppBundle\Entity\Sesion
     */
	public function getSesion() {
		return $this->sesion;
	}
	
	/**
	 * Set sesion
	 * @param \AppBundle\Entity\Sesion $sesion
	 * @return ExpedienteComision
	 */
	public function setSesion($sesion) {
		$this->sesion = $sesion;
		return $this;
	}
	
    /**
     * Set fechaAsignacion
     *
     * @param \DateTime $fechaAsignacion
     *
     * @return ExpedienteComision
     */
    public function setFechaAsignacion($fechaAsignacion)
    {
        $this->fechaAsignacion = $fechaAsignacion;

        return $this;
    }

    /**
     * Get fechaAsignacion
     *
     * @return \DateTime
     */
    public function getFechaAsignacion()
    {
        return $this->fechaAsignacion;
    }

    /**
     * Set expediente
     *
     * @param \AppBundle\Entity\Expediente $expediente
     *
     * @return ExpedienteComision
     */
    public function setExpediente($expediente)
    {
        $this->expediente = $expediente;

        return $this;
    }

    /**
     * Get expediente
     *
     * @return \AppBundle\Entity\Expediente
     */
    public function getExpediente()
    {
        return $this->expediente;
    }

    /**
     * Set comision
     *
     * @param \AppBundle\Entity\Comision $comision
     *
     * @return ExpedienteComision
     */
    public function setComision($comision)
    {
        $this->comision = $comision;

        return $this;
    }

    /**
     * Get comision
     *
     * @return \AppBundle\Entity\Comision
     */
    public function getComision()
    {
        return $this->comision;
    }
    
    /**
     * Get paseOriginario
     * 
     * @return \AppBundle\Entity\Pase
     */
	public function getPaseOriginario() {
		return $this->paseOriginario;
	}
	
	/**
	 * Set paseOriginario
	 * 
	 * @param \AppBundle\Entity\Pase $paseOriginario
	 * 
	 * @return ExpedienteComision
	 */
	public function setPaseOriginario($paseOriginario) {
		$this->paseOriginario = $paseOriginario;
		return $this;
	}
				
	/**
	 * set dictamenMayoria
	 *
	 * @param \AppBundle\Entity\Dictamen $dictamenMayoria
	 *
	 * @return ExpedienteComision
	 */
	public function setDictamenMayoria($dictamenMayoria)
	{
		$this->dictamenMayoria = $dictamenMayoria;
		return $this;
	}
	
	/**
	 * Get dictamenMayoria
	 *
	 * @return \AppBundle\Entity\Dictamen
	 */
	public function getDictamenMayoria()
	{
		return $this->dictamenMayoria;
	}
	
	/**
	 * Get dictamenMayoriaQueAgrega
	 * 
	 * @return \AppBundle\Entity\Dictamen
	 */
	public function getDictamenMayoriaQueAgrega() {
		return $this->dictamenMayoriaQueAgrega;
	}
	
	/**
	 * Set dictamenMayoriaQueAgrega
	 * 
	 * @param \AppBundle\Entity\Dictamen $dictamenMayoriaQueAgrega
	 * @return \AppBundle\Entity\ExpedienteComision
	 */
	public function setDictamenMayoriaQueAgrega(\AppBundle\Entity\Dictamen $dictamenMayoriaQueAgrega) {
		$this->dictamenMayoriaQueAgrega = $dictamenMayoriaQueAgrega;
		return $this;
	}
				
	/**
	 * set dictamenPrimeraMinoria
	 *
	 * @param \AppBundle\Entity\Dictamen $dictamenPrimeraMinoria
	 *
	 * @return ExpedienteComision
	 */
	public function setDictamenPrimeraMinoria($dictamenPrimeraMinoria)
	{
		$this->dictamenPrimeraMinoria = $dictamenPrimeraMinoria;
		return $this;
	}
		
	/**
	 * Get dictamenPrimeraMinoria
	 *
	 * @return \AppBundle\Entity\Dictamen
	 */
	public function getDictamenPrimeraMinoria()
	{
		return $this->dictamenPrimeraMinoria;
	}
	
	/**
	 * Get dictamenPrimeraMinoriaQueAgrega
	 * 
	 * @return \AppBundle\Entity\Dictamen
	 */
	public function getDictamenPrimeraMinoriaQueAgrega() {
		return $this->dictamenPrimeraMinoriaQueAgrega;
	}
	
	/**
	 * Set  dictamenPrimeraMinoriaQueAgrega
	 * 
	 * @param \AppBundle\Entity\Dictamen $dictamenPrimeraMinoriaQueAgrega
	 * @return \AppBundle\Entity\ExpedienteComision
	 */
	public function setDictamenPrimeraMinoriaQueAgrega(\AppBundle\Entity\Dictamen $dictamenPrimeraMinoriaQueAgrega) {
		$this->dictamenPrimeraMinoriaQueAgrega = $dictamenPrimeraMinoriaQueAgrega;
		return $this;
	}
				
	/**
	 * set dictamenSegundaMinoria
	 *
	 * @param \AppBundle\Entity\Dictamen $dictamenSegundaMinoria
	 *
	 * @return ExpedienteComision
	 */
	public function setDictamenSegundaMinoria($dictamenSegundaMinoria)
	{
		$this->dictamenSegundaMinoria = $dictamenSegundaMinoria;
		return $this;
	}
	
	/**
	 * Get dictamenSegundaMinoria
	 *
	 * @return \AppBundle\Entity\Dictamen
	 */
	public function getDictamenSegundaMinoria()
	{
		return $this->dictamenSegundaMinoria;
	}
	
	/**
	 * Get dictamenSegundaMinoriaQueAgrega
	 * 
	 * @return \AppBundle\Entity\Dictamen
	 */
	public function getDictamenSegundaMinoriaQueAgrega() {
		return $this->dictamenSegundaMinoriaQueAgrega;
	}
	
	/**
	 * Set dictamenSegundaMinoriaQueAgrega
	 * 
	 * @param \AppBundle\Entity\Dictamen $dictamenSegundaMinoriaQueAgrega
	 * @return \AppBundle\Entity\ExpedienteComision
	 */
	public function setDictamenSegundaMinoriaQueAgrega(\AppBundle\Entity\Dictamen $dictamenSegundaMinoriaQueAgrega) {
		$this->dictamenSegundaMinoriaQueAgrega = $dictamenSegundaMinoriaQueAgrega;
		return $this;
	}
			
    /**
     * Set anulado
     *
     * @param boolean $anulado
     *
     * @return ExpedienteComision
     */
    public function setAnulado($anulado)
    {
    	$this->anulado= $anulado;
    	
    	return $this;
    }
    
    /**
     * Get anulado
     *
     * @return boolean
     */
    public function getAnulado()
    {
    	return $this->anulado;
    }
    
    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return ExpedienteComision
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
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     *
     * @return ExpedienteComision
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
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     *
     * @return ExpedienteComision
     */
    public function setFechaModificacion($fechaModificacion)
    {
    	$this->fechaModificacion = $fechaModificacion;
    	
    	return $this;
    }
    
    /**
     * Get fechaModificacion
     *
     * @return \DateTime
     */
    public function getFechaModificacion()
    {
    	return $this->fechaModificacion;
    }
    
    /**
     * Set usuarioModificacion
     *
     * @param string $usuarioModificacion
     *
     * @return ExpedienteComision
     */
    public function setUsuarioModificacion($usuarioModificacion)
    {
    	$this->usuarioModificacion = $usuarioModificacion;
    	
    	return $this;
    }
    
    /**
     * Get usuarioModificacion
     *
     * @return string
     */
    public function getUsuarioModificacion()
    {
    	return $this->usuarioModificacion;
    }
    
    //------------------------------------otras propiedades---------------------------------------
    
    /*
     * Get dictamenMayoria
     * 
     * @param integer $idDictamen
     * 
     * @return Dictamen
     
    public function getDictamenMayoria($idDictamen){
    	
    	$dictamenBuscado=null;
    	foreach ($this->dictamenesMayoria as $dictamen){
    		if($dictamen->getId()==$idDictamen)
    			$dictamenBuscado=$dictamen;   		
    	}
    	
    	return $dictamenBuscado;
    }
    
    /**
     * Get dictamenPrimeraMinoria
     *
     * @param integer $idDictamen
     *
     * @return Dictamen
     
    public function getDictamenPrimeraMinoria($idDictamen){
    	
    	$dictamenBuscado=null;
    	foreach ($this->dictamenesPrimeraMinoria as $dictamen){
    		if($dictamen->getId()==$idDictamen)
    			$dictamenBuscado=$dictamen;
    	}
    	
    	return $dictamenBuscado;
    }
    
    /**
     * Get dictamenSegundaMinoria
     *
     * @param integer $idDictamen
     *
     * @return Dictamen
     
    public function getDictamenSegundaMinoria($idDictamen){
    	
    	$dictamenBuscado=null;
    	foreach ($this->dictamenesSegundaMinoria as $dictamen){
    		if($dictamen->getId()==$idDictamen)
    			$dictamenBuscado=$dictamen;
    	}
    	
    	return $dictamenBuscado;
    }
    
    */
    
    //------------------------------Propiedades virtuales-----------------------------------------
    
    		
    		
    /**
     * Get permiteEdicion
     *
     * @return boolean
     * 
     * @VirtualProperty
     */
    public function getPermiteEdicion()
    {
    	return (is_null($this->getSesion()) || $this->getSesion()->getTieneOrdenDelDia()==false);
    }
    
    /**
     * Get sesionMuestra
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getSesionMuestra()
    {
    	return (is_null($this->getSesion())?"":$this->getSesion()->getFechaMuestra());
    }
    
    /**
     * get listaDictamenesMayoriaQueAgrega
     *
     * @return string
     * @VirtualProperty()
     */
    public function getListaDictamenesMayoriaQueAgrega(){
    	
    	$comisiones=(!is_null($this->dictamenMayoriaQueAgrega)
    					?"Agr. a ".($this->dictamenMayoriaQueAgrega
    										 ->getAsignacionesPorMayoria()->get(0))
    										 ->getExpediente()->getNumeroCompleto().
		    			 " (".$this->dictamenMayoriaQueAgrega->getListaLetrasComisionesMayoria().")"
    				    :null);
    	return $comisiones;
    }
    
    /**
     * get listaDictamenesPrimeraMinoriaQueAgrega
     *
     * @return string
     * @VirtualProperty()
     */
    public function getListaDictamenesPrimeraMinoriaQueAgrega(){
    	
    	$comisiones=(!is_null($this->dictamenPrimeraMinoriaQueAgrega)
    					?"Agr. a ".($this->dictamenPrimeraMinoriaQueAgrega
    										 ->getAsignacionesPorPrimeraMinoria()->get(0))
    									     ->getExpediente()->getNumeroCompleto().
		    			 " (".$this->dictamenPrimeraMinoriaQueAgrega->getListaLetrasComisionesPrimeraMinoria().")"
				    	:null);
    	return $comisiones;
    }
    
    /**
     * get listaDictamenesSegundaMinoriaQueAgrega
     *
     * @return string
     * @VirtualProperty()
     */
    public function getListaDictamenesSegundaMinoriaQueAgrega(){
    	
    	$comisiones=(!is_null($this->dictamenSegundaMinoriaQueAgrega)
			    			?"Agr. a ".($this->dictamenPrimeraMinoriaQueAgrega
			    								 ->getAsignacionesPorPrimeraMinoria()->get(0))
			    								 ->getExpediente()->getNumeroCompleto().
					    	" (".$this->dictamenSegundaMinoriaQueAgrega->getListaLetrasComisionesSegundaMinoria().")"
					    	:null);
    	return $comisiones;
    }
    
   
}
