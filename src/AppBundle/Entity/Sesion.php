<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sesion
 *
 * @ORM\Table(name="sesion")
 * @ORM\Entity
 */
class Sesion
{
    //---------------------------------atributos de la clase------------------------------------


    /**
     * @var integer
     *
     * @ORM\Column(name="idSesion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="presentes", type="smallint", nullable=false)
     */
    private $presentes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="quorum", type="boolean", nullable=false)
     */
    private $quorum;

    /**
     * @var integer
     *
     * @ORM\Column(name="periodo", type="smallint", nullable=false)
     */
    private $periodo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AgendaSesion", mappedBy="sesion")
     */
    private $ordenDelDia;

    //-------------------------------------constructor----------------------------------------------

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ordenDelDia = new \Doctrine\Common\Collections\ArrayCollection();
    }

    //------------------------------------setters y getters----------------------------------------

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Sesion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set presentes
     *
     * @param integer $presentes
     *
     * @return Sesion
     */
    public function setPresentes($presentes)
    {
        $this->presentes = $presentes;

        return $this;
    }

    /**
     * Get presentes
     *
     * @return integer
     */
    public function getPresentes()
    {
        return $this->presentes;
    }

    /**
     * Set quorum
     *
     * @param boolean $quorum
     *
     * @return Sesion
     */
    public function setQuorum($quorum)
    {
        $this->quorum = $quorum;

        return $this;
    }

    /**
     * Get quorum
     *
     * @return boolean
     */
    public function getQuorum()
    {
        return $this->quorum;
    }

    /**
     * Set periodo
     *
     * @param integer $periodo
     *
     * @return Sesion
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return integer
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Add agendaSesion
     *
     * @param \AppBundle\Entity\AgendaSesion $agendaSesion
     *
     * @return Sesion
     */
    public function addAgendaSesion(\AppBundle\Entity\AgendaSesion $agendaSesion)
    {
        $this->ordenDelDia[] = $agendaSesion;

        return $this;
    }

    /**
     * Remove agendaSesion
     *
     * @param \AppBundle\Entity\AgendaSesion $agendaSesion
     */
    public function removeAgendaSesion(\AppBundle\Entity\AgendaSesion $agendaSesion)
    {
        $this->ordenDelDia->removeElement($agendaSesion);
    }

    /**
     * Get ordenDelDia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrdenDelDia()
    {
        return $this->ordenDelDia;
    }
}
