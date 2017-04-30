<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpedienteComision
 *
 * @ORM\Table(name="expedienteComision", indexes={@ORM\Index(name="expedienteComision_expediente_idx", columns={"idExpediente"}), 
 *                                                @ORM\Index(name="expedienteComision_comision_idx", columns={"idComision"})})
 * @ORM\Entity
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
     * @ORM\Column(name="fechaAprobacion", type="datetime", nullable=false)
     */
    private $fechaAprobacion;

   /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAsignacion", type="datetime", nullable=false)
     */
    private $fechaAsignacion = 'CURRENT_TIMESTAMP';

   /**
     * @var boolean
     *
     * @ORM\Column(name="aprobado", type="boolean", nullable=false)
     */
    private $aprobado;

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
     * @var \AppBundle\Entity\Comision
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Comision")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idComision", referencedColumnName="idComision")
     * })
     */
    private $comision;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ExpedienteComisionDictamen", mappedBy="expedienteComision")
     */
    private $dictamenes;

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
     * Set fechaAprobacion
     *
     * @param \DateTime $fechaAprobacion
     *
     * @return ProyectoAsignado
     */
    public function setFechaAAprobacion($fechaAprobacion)
    {
        $this->fechaAprobacion = $fechaAprobacion;

        return $this;
    }

    /**
     * Get fechaAprobacion
     *
     * @return \DateTime
     */
    public function getFechaAprobacion()
    {
        return $this->fechaAprobacion;
    }

    /**
     * Set fechaAsignacion
     *
     * @param \DateTime $fechaAsignacion
     *
     * @return ProyectoAsignado
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
     * Set aprobado
     *
     * @param boolean $aprobado
     *
     * @return ProyectoAsignado
     */
    public function setAprobado($aprobado)
    {
        $this->aprobado = $aprobado;

        return $this;
    }

    /**
     * Get esLegislador
     *
     * @return boolean
     */
    public function getAprobado()
    {
        return $this->aprobado;
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
     * @return ProtectoAsignado
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
     * Add dictamen
     *
     * @param \AppBundle\Entity\ExpedienteComisionDictamen $dictamen
     *
     * @return ExpedienteComision
     */
    public function addDictamen(\AppBundle\Entity\ExpedienteComisionDictamen $dictamen)
    {
        $this->dictamenes[] = $dictamen;

        return $this;
    }

    /**
     * Remove dictamen
     *
     * @param \AppBundle\Entity\ExpedienteComisionDictamen $dictamen
     */
    public function removeDictamen(\AppBundle\Entity\ExpedienteComisionDictamen $dictamen)
    {
        $this->dictamenes->removeElement($dictamen);
    }

   
}
