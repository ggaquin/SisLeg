<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\ORM\Mapping\InheritanceType;

/**
 * ExpedienteSesion
 *
 * @ORM\Table(name="ExpedienteSesion", indexes={@ORM\Index(name="agendaSesion_expediente_idx", columns={"idExpediente"}), 
 *                                          	@ORM\Index(name="agendaSesion_sesion_idx", columns={"idSesion"}), 
 *                                          	@ORM\Index(name="expedienteSesion_estadoExpedienteSesion_idx", columns={"idEstadoExpedienteSesion"})})
 * @ORM\Entity
 */

 /*
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminador", type="string", length=15)
 * @ORM\DiscriminatorMap({"ItemA" = "AppBundle\Entity\ExpedienteSeSionItemA", 
 *                        "ItemB" = "AppBundle\Entity\ExpedienteSeSionItemB",
 *                        "ItemC" = "AppBundle\Entity\ExpedienteSeSionItemC",
 *                        "ItemD" == "AppBundle\Entity\ExpedienteSeSionItemD",
 *                        "ItemE" == "AppBundle\Entity\ExpedienteSeSionItemE"
 *                        })
 */
abstract class ExpedienteSesion
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
     * @var innteger
     * 
     * @ORM\Column(name="ordenSesion" ,type="smallint", nullable=false)
     */
    private $ordenSesion;

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
    
    //----------------------------------------METODOS ABSTRACTOS----------------------------------------
    
    public abstract function getDatosAImprimir();
}
