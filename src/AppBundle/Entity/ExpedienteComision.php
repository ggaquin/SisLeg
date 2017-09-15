<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * ExpedienteComision
 *
 * @ORM\Table(name="expedienteComision", indexes={@ORM\Index(name="expedienteComision_expediente_idx", columns={"idExpediente"}), 
 *                                                @ORM\Index(name="expedienteComision_comision_idx", columns={"idComision"}),
 *                                                @ORM\Index(name="expedienteComision_movimiento_idx", columns={"idMovimiento"})
 *                                               })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExpedienteComisionRepository")
 */
class ExpedienteComision
{
    //------------------------------atributos de la clase-----------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idExpdienteComision", type="int")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
 
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
     * @var \AppBundle\Entity\Dictamen
     * 
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Dictamen", cascade={"persist"}, inversedBy="asignacionesPorMayoria")
     * @ORM\JoinTable(name="expedienteComision_dictamenesMayoria", 
     * 	joinColumns={@ORM\JoinColumn(name="idExpedienteComision", referencedColumnName="idExpedienteComision")},
     * 	inverseJoinColumns={@ORM\JoinColumn(name="idDictamen", referencedColumnName="idDictamen")}
     * )
     */
    private $dictamenesMayoria;
    
    /**
     * @var \AppBundle\Entity\Dictamen
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Dictamen", cascade={"persist"}, inversedBy="asignacionesPorMayoria")
     * @ORM\JoinTable(name="expedienteComision_dictamenesPrimeraMinoria", 
     * 	joinColumns={@ORM\JoinColumn(name="idExpedienteComision", referencedColumnName="idExpedienteComision")},
     * 	inverseJoinColumns={@ORM\JoinColumn(name="idDictamen", referencedColumnName="idDictamen")}
     * )
     */
    private $dictamenesPrimeraMinoria;
    
    /**
     * @var \AppBundle\Entity\Dictamen
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Dictamen", cascade={"persist"}, inversedBy="asignacionesPorMayoria")
     * @ORM\JoinTable(name="expedienteComision_dictamenesSegundaMinoria", 
     * 	joinColumns={@ORM\JoinColumn(name="idExpedienteComision", referencedColumnName="idExpedienteComision")},
     * 	inverseJoinColumns={@ORM\JoinColumn(name="idDictamen", referencedColumnName="idDictamen")}
     * )
     */
    private $dictamenesSegundaMinoria;
        
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
    	$this->publicado = false;
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
	 * set dictamenesMayoria
	 *
	 * @param array $dictamenesMayoria
	 *
	 * @return ExpedienteComision
	 */
	public function setDictamenesMayoria($dictamenesMayoria)
	{
		$collection= new \Doctrine\Common\Collections\ArrayCollection();
		foreach ($dictamenesMayoria as $dictamenMayoria) {
			$collection[]=$dictamenMayoria;
		}
		$this->dictamenesMayoria = $collection;
		
		return $this;
	}
	
	/**
	 * Add dictamenMayoria
	 *
	 * @param \AppBundle\Entity\Dictamen $dictamenMayoria
	 *
	 * @return ExpedienteComision
	 */
	public function addDictamenMayoria(\AppBundle\Entity\Dictamen $dictamenMayoria)
	{
		$this->dictamenesMayoria[] = $dictamenMayoria;
		
		return $this;
	}
	
	/**
	 * Remove dictamenMayoria
	 *
	 * @param \AppBundle\Entity\Dictamen $dictamenMayoria
	 *
	 * @return ExpedienteComision
	 */
	public function removeDictamenMayoria(\AppBundle\Entity\Dictamen $dictamenMayoria)
	{
		$this->dictamenesMayoria->removeElement($dictamenMayoria);
		return $this;
	}
	
	/**
	 * Get dictamenesMayoria
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getDictamenesMayoria()
	{
		return $this->dictamenesMayoria;
	}
	
	/**
	 * set dictamenesPrimeraMinoria
	 *
	 * @param array $dictamenesPrimeraMinoria
	 *
	 * @return ExpedienteComision
	 */
	public function setDictamenesPrimeraMinoria($dictamenesPrimeraMinoria)
	{
		$collection= new \Doctrine\Common\Collections\ArrayCollection();
		foreach ($dictamenesPrimeraMinoria as $dictamenPrimeraMinoria) {
			$collection[]=$dictamenPrimeraMinoria;
		}
		$this->dictamenesPrimeraMinoria = $collection;
		
		return $this;
	}
	
	/**
	 * Add dictamenPrimeraMinoria
	 *
	 * @param \AppBundle\Entity\Dictamen $dictamenPrimeraMinoria
	 *
	 * @return ExpedienteComision
	 */
	public function addDictamenPrimeraMinoria(\AppBundle\Entity\Dictamen $dictamenPrimeraMinoria)
	{
		$this->dictamenesPrimeraMinoria[] = $dictamenPrimeraMinoria;
		
		return $this;
	}
	
	/**
	 * Remove dictamenPrimeraMinoria
	 *
	 * @param \AppBundle\Entity\Dictamen $dictamenPrimeraMinoria
	 *
	 * @return ExpedienteComision
	 */
	public function removeDictamenPrimeraMinoria(\AppBundle\Entity\Dictamen $dictamenPrimeraMinoria)
	{
		$this->dictamenesPrimeraMinoria->removeElement($dictamenPrimeraMinoria);
		return $this;
	}
	
	/**
	 * Get dictamenesPrimeraMinoria
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getDictamenesPrimeraMinoria()
	{
		return $this->dictamenesPrimeraMinoria;
	}
	
	/**
	 * set dictamenesSegundaMinoria
	 *
	 * @param array $dictamenesSegundaMinoria
	 *
	 * @return ExpedienteComision
	 */
	public function setictamenesSegundaMinoria($dictamenesSegundaMinoria)
	{
		$collection= new \Doctrine\Common\Collections\ArrayCollection();
		foreach ($dictamenesSegundaMinoria as $dictamenSegundaMinoria) {
			$collection[]=$dictamenSegundaMinoria;
		}
		$this->dictamenesSegundaMinoria = $collection;
		
		return $this;
	}
	
	/**
	 * Add dictamenSegundaMinoria
	 *
	 * @param \AppBundle\Entity\Dictamen $dictamenSegundaMinoria
	 *
	 * @return ExpedienteComision
	 */
	public function addDictamenSegundaMinoria(\AppBundle\Entity\Dictamen $dictamenSegundaMinoria)
	{
		$this->dictamenesSegundaMinoria[] = $dictamenSegundaMinoria;
		
		return $this;
	}
	
	/**
	 * Remove dictamenSegundaMinoria
	 *
	 * @param \AppBundle\Entity\Dictamen $dictamenSegundaMinoria
	 *
	 * @return ExpedienteComision
	 */
	public function removeDictamenSegundaMinoria(\AppBundle\Entity\Dictamen $dictamenSegundaMinoria)
	{
		$this->dictamenesSegundaMinoria->removeElement($dictamenSegundaMinoria);
		return $this;
	}
	
	/**
	 * Get dictamenesSegundaMinoria
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getDictamenesSegundaMinoria()
	{
		return $this->dictamenesSegundaMinoria;
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
    
    /**
     * Get dictamenMayoria
     * 
     * @param integer $idDictamen
     * 
     * @return Dictamen
     */
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
     */
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
     */
    public function getDictamenSegundaMinoria($idDictamen){
    	
    	$dictamenBuscado=null;
    	foreach ($this->dictamenesSegundaMinoria as $dictamen){
    		if($dictamen->getId()==$idDictamen)
    			$dictamenBuscado=$dictamen;
    	}
    	
    	return $dictamenBuscado;
    }
    
    //------------------------------Propiedades virtuales-----------------------------------------
       
    /**
     * Get listaDictamenesMayoria
     *
     * @return array
     * 
     * @VirtualProperty
     */
    public function getListaDictamenesMayoria()
    {
    	$listaDictamenesMayoria=[];
    	foreach ($this->dictamenesMayoria as $dictamen)
    		$listaDictamenesMayoria[]=array('id'=>$dictamen->getId(),
    										'sesion'=>(!is_null($dictamen->getSesion())
    															?$dictamen->getSesion()->getFechaMuestra()
    															:'Sin Sesión')
    										);
    	return $listaDictamenesMayoria;
    }
    
    /**
     * Get listaDictamenesPrimeraMinoria
     *
     * @return array
     * 
     * @VirtualProperty
     */
    public function getListaDictamenesPrimeraMinoria()
    {
    	$listaDictamenesPrimeraMinoria=[];
    	foreach ($this->dictamenesPrimeraMinoria as $dictamen)
    		$listaDictamenesPrimeraMinoria[]=array('id'=>$dictamen->getId(),
								    			   'sesion'=>(!is_null($dictamen->getSesion())
								    						  ?$dictamen->getSesion()->getFechaMuestra()
								    						  :'Sin Sesión')
    										);
    		return $listaDictamenesPrimeraMinoria;
    }
    
    /**
     * Get listaDictamenesSegundaMinoria
     *
     * @return array
     *	
     * @VirtualProperty
     */
    public function getListaDictamenesSegundaMinoria()
    {
    	$listaDictamenesSegundaMinoria=[];
    	foreach ($this->dictamenesSegundaMinoria as $dictamen)
    		$listaDictamenesSegundaMinoria[]=array('id'=>$dictamen->getId(),
								    			   'sesion'=>(!is_null($dictamen->getSesion())
								    						  ?$dictamen->getSesion()->getFechaMuestra()
								    						  :'Sin Sesión')
    											  );
    		return $listaDictamenesSegundaMinoria;
    }
    
}
