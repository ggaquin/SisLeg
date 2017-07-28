<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dictamen
 *
 * @ORM\Table(name="dictamen",  uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_dictamen_proyectoRevision_idx",columns={"idProyectoRevision"})},
 * 								indexes={@ORM\Index(name="dictamen_tipoDictamen_idx", columns={"idTipoDictamen"})})
 * @ORM\Entity
 */
class Dictamen
{
    //------------------------------atributos de la clase-----------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idDictamen", type="int")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\TipoDictamen
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoDictamen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTipoDictamen", referencedColumnName="idTipoDictamen")
     * })
     */
    private $tipoDictamen;
    
    /**
     * @var \AppBundle\Entity\ProyectoRevision
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\ProyectoRevision")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProyectoRevision",referencedColumnName="idProyectoRevision")
     * })
     */
    private $revisionDictamen;

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
     * Set tipoDictamen
     *
     * @param \AppBundle\Entity\TipoDictamen $tipoDictamen
     *
     * @return Dictamen
     */
    public function setTipoDictamen(\AppBundle\Entity\TipoDictamen $tipoDictamen= null)
    {
    	$this->tipoDictamen= $tipoDictamen;

        return $this;
    }

    /**
     * Get tipoDictamen
     *
     * @return \AppBundle\Entity\TipoDictamen
     */
    public function getTipoDictamen()
    {
        return $this->tipoDictamen;
    }
    
    /**
     * Set revisionDictamen
     *
     * @param \AppBundle\Entity\ProyectoRevision $proyectoRevision
     *
     * @return Dictamen
     */
    public function setRevisionDisctamen(\AppBundle\Entity\ProyectoRevision $proyectoRevision= null)
    {
    	$this->revisionDictamen= $proyectoRevision;
    	
    	return $this;
    }
    
    /**
     * Get revisionDictamen
     *
     * @return \AppBundle\Entity\ProyectoRevision
     */
    public function getRevisionDisctamen()
    {
    	return $this->revisionDictamen;
    }

     /**
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     *
     * @return Dictamen
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
