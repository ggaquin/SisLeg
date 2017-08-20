<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * ExpedienteComision
 *
 * @ORM\Table(name="expedienteComision", indexes={@ORM\Index(name="expedienteComision_expediente_idx", columns={"idExpediente"}), 
 *                                                @ORM\Index(name="expedienteComision_comision_idx", columns={"idComision"}),
 *                                                @ORM\Index(name="expedienteComision_sesion_idx", columns={"idSesion"}),
 *                                                @ORM\Index(name="expedienteComision_movimiento_idx", columns={"idMovimiento"}),
 *                                                @ORM\Index(name="expedienteComision_dictamenMayoria_idx", columns={"idDictamenMayoria"}),
 *                                                @ORM\Index(name="expedienteComision_dictamenPrimeraMinoria_idx", columns={"idDictamenPrimeraMinoria"}),
 *                                                @ORM\Index(name="expedienteComision_dictamenSegundaMinoria_idx", columns={"idDictamenSegundaMinoria"})
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechaPublicacion", type="datetime", nullable=true)
     */
    private $fechaPublicacion;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dictamen", cascade={"persist"}, inversedBy="asignacionesPorMayoria")
     * @ORM\JoinColumns({
     * 		@ORM\JoinColumn(name="idDictamenMayoria", referencedColumnName="idDictamen")
     * })
     */
    private $dictamenMayoria;
    
    /**
     * @var \AppBundle\Entity\Dictamen
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dictamen", cascade={"persist"}, inversedBy="asignacionesPorPrimeraMinoria")
     * @ORM\JoinColumns({
     * 		@ORM\JoinColumn(name="idDictamenPrimeraMinoria", referencedColumnName="idDictamen")
     * })
     */
    private $dictamenPrimeraMinoria;
    
    /**
     * @var \AppBundle\Entity\Dictamen
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dictamen", cascade={"persist"}, inversedBy="asignacionesPorSegundaMinoria")
     * @ORM\JoinColumns({
     * 		@ORM\JoinColumn(name="idDictamenSegundaMinoria", referencedColumnName="idDictamen")
     * })
     */
    private $dictamenSegundaMinoria;
        
    /**
     * @var boolean
     * @ORM\Column(name="anulado", type="boolean", nullable=false)
     */
    private $anulado;
    
    /**
     * @var \AppBundle\Entity\Sesion
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sesion")
     * @ORM\JoinColumns({
     * 		@ORM\JoinColumn(name="idSesion",referencedColumnName="idSesion")
     * })
     */
    private $sesion;
    
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
     * Set sesion
     *
     * @param \AppBundle\Entity\Sesion $sesion
     *
     * @return ExpedienteComision
     */
    public function setSesion($sesion)
    {
    	$this->sesion = $sesion;
    	
    	return $this;
    }
    
    /**
     * Get sesion	
     *
     * @return \AppBundle\Entity\Sesion
     */
    public function getSesion()
    {
    	return $this->sesion;
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
     * Get dictamenMayoria
     * 
     * @return \AppBundle\Entity\Dictamen
     */
	public function getDictamenMayoria() {
		return $this->dictamenMayoria;
	}
	
	/**
	 * Set dictamenMayoria
	 * 
	 * @param \AppBundle\Entity\Dictamen $dictamenMayoria
	 * 
	 * @return ExpedienteComision
	 */
	public function setDictamenMayoria($dictamenMayoria) {
		$this->dictamenMayoria = $dictamenMayoria;
		return $this;
	}
	
	/**
	 * Get dictamenPrimeraMinoria
	 * 
	 * @return \AppBundle\Entity\Dictamen
	 */
	public function getDictamenPrimeraMinoria() {
		return $this->dictamenPrimeraMinoria;
	}
	
	/**
	 * Set dictamenPrimeraMinoria
	 * 
	 * @param \AppBundle\Entity\Dictamen $dictamenPrimeraMinoria
	 * 
	 * @return ExpedienteComision
	 */
	public function setDictamenPrimeraMinoria($dictamenPrimeraMinoria) {
		$this->dictamenPrimeraMinoria = $dictamenPrimeraMinoria;
		return $this;
	}
	
	/**
	 * Get dictamenSegundaMinoria
	 * 
	 * @return \AppBundle\Entity\Dictamen
	 */
	public function getDictamenSegundaMinoria() {
		return $this->dictamenSegundaMinoria;
	}
	
	/**
	 * Set dictamenSegundaMinoria
	 * 
	 * @param \AppBundle\Entity\Dictamen $dictamenSegundaMinoria
	 * 
	 * @return ExpedienteComision
	 */
	public function setDictamenSegundaMinoria($dictamenSegundaMinoria) {
		$this->dictamenSegundaMinoria = $dictamenSegundaMinoria;
		return $this;
	}
        
    /**
     * Set fechaPublicacion
     *
     * @param \DateTime $fechaPublicacion
     *
     * @return ExpedienteComision
     */
    public function setFechaPublicacion($fechaPublicacion)
    {
    	$this->fechaPublicacion= $fechaPublicacion;
    	
    	return $this;
    }
    
    /**
     * Get fechaPublicacion
     *
     * @return \DateTime
     */
    public function getFechaPublicacion()
    {
    	return $this->fechaPublicacion;
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
    
    //------------------------------Propiedades virtuales-----------------------------------------
   
    /**
     * Get fechaPublicacionFormateada
     *
     * @return string
     * 
     * @VirtualProperty
     */
    public function getFechaPublicacionFormateada()
    {
    	 return ((!is_null($this->fechaPublicacion))?$this->fechaPublicacion->format('d/m/Y'):'');
    }
    
    /**
     * Get SesionMuestra
     * 
     * @return string
     * 
     * @VirtualProperty
     */
    public function getSesionMuestra(){
    	return ((is_null($this->getSesion()))?null:$this->getSesion()->getFechaMuestra());
    }
    
    /**
     * Get tieneDictamenMayoria
     *
     * @return boolean
     * 
     * @VirtualProperty
     */
    public function getTieneDictamenMayoria()
    {
    	return !is_null($this->getDictamenMayoria());
    }
    
    /**
     * Get tieneDictamenPrimeraMinoria
     *
     * @return boolean
     *
     * @VirtualProperty
     */
    public function getTieneDictamenPrimeraMinoria()
    {
    	return !is_null($this->getDictamenPrimeraMinoria());
    }
    
    /**
     * Get tieneDictamenSegundaMinoria
     *
     * @return boolean
     *
     * @VirtualProperty
     */
    public function getTieneDictamenSegundaMinoria()
    {
    	return !is_null($this->getDictamenSegundaMinoria());
    }
    
}
