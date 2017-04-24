<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgendaSesion
 *
 * @ORM\Table(name="agendaSesion", indexes={@ORM\Index(name="expediente1_idx", columns={"idExpediente"}), 
 *                                          @ORM\Index(name="sesion_idx", columns={"idSesion"}), 
 *                                          @ORM\Index(name="estadoAgendaesion_idx", columns={"idEstadoAgendaSesion"})})
 * @ORM\Entity
 */
class AgendaSesion
{   
    //--------------------------------atributos de la clase----------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idAgendaSesion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @var \AppBundle\Entity\EstadoAgendaSesion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EstadoAgendaSesion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEstadoAgendaSesion", referencedColumnName="idEstadoAgendaSesion")
     * })
     */
    private $estadoAgendaSesion;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sesion", inversedBy="ordenDelDia")
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
     * Set aFavor
     *
     * @param integer $aFavor
     *
     * @return Agenda
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
     * @return Agenda
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
     * @return Agenda
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
     * Set estadoAgendaSesion
     *
     * @param \AppBundle\Entity\EstadoAgendaSesion $estadoAgendaSesion
     *
     * @return AgendaSesion
     */
    public function setEstadoAgendaSesion(\AppBundle\Entity\EstadoAgendaSesion $estadoAgendaSesion = null)
    {
        $this->estadoAgendaSesion = $estadoAgendaSesion;

        return $this;
    }

    /**
     * Get estadoAgendaSesion
     *
     * @return \AppBundle\Entity\EstadoAgendaSesion
     */
    public function getEstadoAgendaSesion()
    {
        return $this->estadoAgendaSesion;
    }

    /**
     * Set expediente
     *
     * @param \AppBundle\Entity\Expediente $expediente
     *
     * @return AgendaSesion
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
     * @return Agenda
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
}
