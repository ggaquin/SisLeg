<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpedienteComisionDictamen
 *
 * @ORM\Table(name="expedienteComisionDictamen", indexes={@ORM\Index(name="expedienteComisionDictamen_expedienteComision_idx", columns={"idExpedienteComision"})})
 * @ORM\Entity
 */
class ExpedienteComisionDictamen
{
    //------------------------------atributos de la clase-----------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idExpedienteComisionDictamen", type="int")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\ExpedienteComision
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ExpedienteComision")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idExpedienteComision", referencedColumnName="idExpedienteComision")
     * })
     */
    private $expedienteComision;

   /**
     * @var string
     *
     * @ORM\Column(name="dictamen", length="500", type="string", nullable=false)
     */
    private $dictamen;

    /**
     * @var string
     *
     * @ORM\Column(name="usuarioCreacion", length="70", type="string", nullable=false)
     */
    private $usuarioCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;

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
     * Set expedienteComision
     *
     * @param \AppBundle\Entity\ExpedienteComision $expedienteComision
     *
     * @return ExpedienteComisionDictamen
     */
    public function setExpedienteComision(\AppBundle\Entity\ExpedienteComision $expedienteComision = null)
    {
        $this->expedienteComision = $expedienteComision;

        return $this;
    }

    /**
     * Get expedienteComision
     *
     * @return \AppBundle\Entity\ExpedienteComision
     */
    public function getExpedienteComision()
    {
        return $this->expedienteComisio;
    }

    /**
     * Set dictamen
     *
     * @param string $dictamen
     *
     * @return ExpedienteComisionDictamen
     */
    public function setDictamen($dictamen)
    {
        $this->dictamen = $dictamen;

        return $this;
    }

    /**
     * Get dictame
     *
     * @return string
     */
    public function getDictamen()
    {
        return $this->dictamen;
    }

     /**
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     *
     * @return ExpedienteComisionDictamen
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
     * @return ProyectoAsignado
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

   
}
