<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * ExpedienteComision
 *
 * @ORM\Table(name="expedienteComision", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_expedienteComision_dictamen_idx",
 *                                                 columns={"idDictamen"})},
 * 										 indexes={@ORM\Index(name="expedienteComision_expediente_idx", columns={"idExpediente"}), 
 *                                                @ORM\Index(name="expedienteComision_comision_idx", columns={"idComision"})
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Expediente", inversedBy="asignacionComisiones")
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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Dictamen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idDictamen", referencedColumnName="idDictamen")
     * })
     */
    private $dictamen; 
    
   /**
    * @var boolean
    * @ORM\Column(name="publicado", type="boolean", nullable=false)
    */ 
    private $publicado;
    
    /**
     * @var boolean
     * @ORM\Column(name="anulado", type="boolean", nullable=false)
     */
    private $anulado;
    
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
     * Set dictamen
     *
     * @param \AppBundle\Entity\Dictamen $dictamen
     *
     * @return ExpedienteComision
     */
    public function setDictamen(\AppBundle\Entity\Dictamen $dictamen)
    {
        $this->dictamen = $dictamen;

        return $this;
    }

    /**
     * get dictamen
     *
     * @param \AppBundle\Entity\Dictamen $dictamen
     */
    public function getDictamen()
    {
        return $this->dictamen;
    }
    
    /**
     * Set publicado
     *
     * @param boolean $publicado
     *
     * @return ExpedienteComision
     */
    public function setPublicado($publicado)
    {
    	$this->publicado = $publicado;
    	
    	return $this;
    }
    
    /**
     * Get publicado
     *
     * @return boolean
     */
    public function getPublicado()
    {
    	return $this->publicado;
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
     * Get tieneDictamen
     *
     * @return string
     * 
     * @VirtualProperty
     */
    public function getTieneDictamen()
    {
    	return !is_null($this->dictamen);
    }
    
}
