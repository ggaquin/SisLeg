<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpedienteSesion
 *
 * @ORM\Table(name="expedienteSesion", indexes={@ORM\Index(name="agendaSesion_expediente_idx", columns={"idExpediente"}), 
 *                                          	@ORM\Index(name="agendaSesion_sesion_idx", columns={"idSesion"}), 
 *                                          	@ORM\Index(name="expedienteSesion_estadoExpedienteSesion_idx", columns={"idEstadoExpedienteSesion"}),
 *                                          	@ORM\Index(name="expedienteSesion_tipoExpedienteSesion_idx", columns={"idTipoExpedienteSesion"}),
 *            					 			   },
 *            							uniqueConstraints={@ORM\UniqueConstraint(name="expedienteSesion_resolucion_idx", columns={"idResolucion"})}
 *            )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExpedienteSesionRepository")
 */
class ExpedienteSesion
{   
    //--------------------------------atributos de la clase----------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idExpedienteSesion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var \AppBundle\Entity\TipoExpedienteSesion
     * 
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\TipoExpedienteSesion")
     * @ORM\JoinColumns({
     * 		@ORM\JoinColumn(name="idTipoExpedienteSesion", referencedColumnName="idTipoExpedienteSesion")
     * })
     */
    private $tipoExpedienteSesion;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="ordenSesion" ,type="smallint", nullable=false)
     */
    private $ordenSesion;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="texto", type="text", nullable=false)
     */
    private $texto;

    /**
     * @var integer
     *
     * @ORM\Column(name="aFavor", type="smallint", nullable=false)
     */
    private $aFavor = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="enContra", type="smallint", nullable=false)
     */
    private $enContra = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="abstenciones", type="smallint", nullable=false)
     */
    private $abstenciones = '0';

    /**
     * @var \AppBundle\Entity\EstadoExpedienteSesion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EstadoExpedienteSesion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEstadoExpedienteSesion", referencedColumnName="idEstadoExpedienteSesion")
     * })
     */
    private $estadoExpedienteSesion;

    /**
     * @var \AppBundle\Entity\Expediente
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idExpediente", referencedColumnName="idExpediente")
     * })
     */
    private $expediente;

    /**
     * @var \AppBundle\Entity\Sesion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sesion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSesion", referencedColumnName="idSesion")
     * })
     */
    private $sesion;
    
    /**
     * @var \AppBundle\Entity\Resolucion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Resolucion")
     * @ORM\JoinColumn(name="idResolucion", referencedColumnName="idResolucion")
     */
    private $resolucion;

    //------------------------------------setters y getters---------------------------------------

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
     * Get tipoExpedienteSesion
     * 
     * @return TipoExpedienteSesion
     */
	public function getTipoExpedienteSesion() {
		return $this->tipoExpedienteSesion;
	}
	
	/**
	 * Set tipoExpedienteSesion
	 * 
	 * @param \AppBundle\Entity\TipoExpedienteSesion $tipoExpedienteSesion
	 * 
	 * @return ExpedienteSesion
	 */
	public function setTipoExpedienteSesion($tipoExpedienteSesion) {
		$this->tipoExpedienteSesion = $tipoExpedienteSesion;
		return $this;
	}
	    
    /**
     * Get ordenSesion
     * 
     * @return integer
     */
	public function getOrdenSesion() {
		return $this->ordenSesion;
	}
	
	/**
	 * Set ordenSesion
	 * 
	 * @param integer $ordenSesion
	 * 
	 * @return ExpedienteSesion
	 */
	public function setOrdenSesion($ordenSesion) {
		$this->ordenSesion = $ordenSesion;
		return $this;
	}
	
	/**
	 * Get texto
	 * 
	 * @return string
	 */
	public function getTexto() {
		return $this->texto;
	}
	
	/**
	 * Set texto
	 * 
	 * @param string $texto
	 * 
	 * @return ExpedienteSesion
	 */
	public function setTexto($texto) {
		$this->texto = $texto;
		return $this;
	}
		
    /**
     * Set aFavor
     *
     * @param integer $aFavor
     *
     * @return ExpedienteSesion
     */
    public function setAFavor($aFavor)
    {
        $this->aFavor = $aFavor;

        return $this;
    }

    /**
     * Get aFavor
     *
     * @return integer
     */
    public function getAFavor()
    {
        return $this->aFavor;
    }

    /**
     * Set enContra
     *
     * @param integer $enContra
     *
     * @return ExpedienteSesion
     */
    public function setEnContra($enContra)
    {
        $this->enContra = $enContra;

        return $this;
    }

    /**
     * Get enContra
     *
     * @return integer
     */
    public function getEnContra()
    {
        return $this->enContra;
    }

    /**
     * Set abstenciones
     *
     * @param integer $abstenciones
     *
     * @return ExpedienteSesion
     */
    public function setAbstenciones($abstenciones)
    {
        $this->abstenciones = $abstenciones;

        return $this;
    }

    /**
     * Get abstenciones
     *
     * @return integer
     */
    public function getAbstenciones()
    {
        return $this->abstenciones;
    }

    /**
     * Set estadoExpedienteSesion
     *
     * @param \AppBundle\Entity\EstadoExpedienteSesion $estadoExpedienteSesion
     *
     * @return ExpedienteSesion
     */
    public function setEstadoExpedienteSesion(\AppBundle\Entity\EstadoExpedienteSesion $estadoExpedienteSesion= null)
    {
    	$this->estadoExpedienteSesion = $estadoExpedienteSesion;

        return $this;
    }

    /**
     * Get estadoExpedienteSesion
     *
     * @return \AppBundle\Entity\EstadoExpedienteSesion
     */
    public function getEstadoExpedienteSesion()
    {
        return $this->estadoExpedienteSesion;
    }

    /**
     * Set expediente
     *
     * @param \AppBundle\Entity\Expediente $expediente
     *
     * @return ExpedienteSesion
     */
    public function setExpediente(\AppBundle\Entity\Expediente $expediente = null)
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
     * Set sesion
     *
     * @param \AppBundle\Entity\Sesion $sesion
     *
     */
    public function setSesion(\AppBundle\Entity\Sesion $sesion = null)
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
     * Get resolucion
     * 
     * @return \AppBundle\Entity\Resolucion
     */
	public function getResolucion() {
		return $this->resolucion;
	}
	
	/**
	 * Set resolucion
	 * 
	 * @param \AppBundle\Entity\Resolucion $resolucion
	 * 
	 * @return \AppBundle\Entity\ExpedienteSesion
	 */
	public function setResolucion($resolucion) {
		$this->resolucion = $resolucion;
		return $this;
	}
	    
}
