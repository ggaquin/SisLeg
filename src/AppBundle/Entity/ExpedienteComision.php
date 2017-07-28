<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpedienteComision
 *
 * @ORM\Table(name="expedienteComision", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_expedienteComision_dictamen_idx",
 *                                                 columns={"idDictamen"})},
 * 										 indexes={@ORM\Index(name="expedienteComision_expediente_idx", columns={"idExpediente"}), 
 *                                                @ORM\Index(name="expedienteComision_comision_idx", columns={"idComision"})
 *                                               })
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
     * @ORM\Column(name="fechaAsignacion", type="datetime", nullable=false)
     */
    private $fechaAsignacion = 'CURRENT_TIMESTAMP';

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
    * @ORM\Column(name="asignacionActual", type="boolean", nullable=false)
    */ 
    private $asignacionActual;

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
     * Set asignacionActual
     *
     * @param boolean $asignacionActual
     *
     * @return ExpedienteComision
     */
    public function setAsignacionActual($asignacionActual)
    {
    	$this->asignacionActual = $asignacionActual;
    	
    	return $this;
    }
    
    /**
     * Get asignacionActual
     *
     * @return boolean
     */
    public function getAsignacionActual()
    {
    	return $this->asignacionActual;
    }
   
}
