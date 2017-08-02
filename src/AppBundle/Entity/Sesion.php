<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Sesion
 *
 * @ORM\Table(name="sesion", indexes={@ORM\Index(name="sesion_tipoSesion_idx", columns={"idTipoSesion"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SesionRepository")
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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=50, nullable=false)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="presentes", type="smallint", nullable=true)
     */
    private $presentes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="quorum", type="boolean", nullable=true)
     */
    private $quorum;

    /**
     * @var integer
     *
     * @ORM\Column(name="año", type="smallint", nullable=false)
     */
    private $año;
    
    /**
     * @var \AppBundle\Entity\TipoSesion
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoSesion")
     * @ORM\JoinColumns({
     * 		@ORM\JoinColumn(name="idTipoSesion", referencedColumnName="idTipoSesion")
     * })
     */
    private $tipoSesion;

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
        $this->quorum=false;
        $this->presentes=0;
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Sesion
     */
    public function setDescripcion($descripcion)
    {
    	$this->descripcion = $descripcion;
    	
    	return $this;
    }
    
    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
    	return $this->descripcion;
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
     * Set año
     *
     * @param integer $año
     *
     * @return Sesion
     */
    public function setAño($año)
    {
    	$this->año = $año;

        return $this;
    }

    /**
     * Get año
     *
     * @return integer
     */
    public function getAño()
    {
        return $this->año;
    }
    
    /**
     * Set tipoSesion
     *
     * @param \AppBundle\Entity\TipoSesion $tipoSesion
     *
     * @return Sesion
     */
    public function setTipoSesion($tipoSesion)
    {
    	$this->tipoSesion = $tipoSesion;
    	
    	return $this;
    }
    
    /**
     * Get tipoSesion
     *
     * @return \AppBundle\Entity\TipoSesion $tipoSesion
     */
    public function getTipoSesion()
    {
    	return $this->tipoSesion;
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
    
    //--------------------------------Propiedades Virtuales-----------------------------------
    
    /**
     * Get fechaFormateada
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getFechaFormateada()
    {
    	return $this->fecha->format('d/m/Y');
    }
}
