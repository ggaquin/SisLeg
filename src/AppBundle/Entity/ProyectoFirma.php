<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProyectoFirma
 *
 * @ORM\Table(name="proyectoFirma",indexes={@ORM\Index(name="proyectoFirma_perfil_idx", columns={"idPerfil"}), 
 *                                          @ORM\Index(name="proyectoFirma_proyecto_idx", columns={"idProyecto"})})
 * @ORM\Entity
 */
class ProyectoFirma
{
    //-------------------------------Atributos de la clase----------------------------------------
    
    /**
     * @var integer
     *
     * @ORM\Column(name="idProyectoFirma", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Perfil
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Perfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPerfil", referencedColumnName="idPerfil")
     * })
     */
    private $autor;


     /**
     * @var \AppBundle\Entity\Proyecto
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Proyecto", inversedBy="firmas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProyecto", referencedColumnName="idProyecto")
     * })
     */
    private $proyecto;

    /**
     * @var boolean
     *
     * @ORM\Column(name="confirmado", type="boolean", nullable=false)
     */
    private $confirmado=false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaConfirmacion", type="datetime", nullable=true)
     */
    private $fechaConfirmacion;

    //------------------------------------constructor---------------------------------------------

    /*
     * Constructor
     *
    public function __construct()
    {
       $confirmado=false;
    }
    */
   
    //--------------------------------setters y getters-------------------------------------------


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
     * Set autor
     *
     * @param \AppBundle\Entity\Perfil $autor
     *
     * @return ProyectoFirma
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return \AppBundle\Entity\Perfil
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set proyecto
     *
     * @param \AppBundle\Entity\Proyecto $proyecto
     *
     * @return ProyectoFirma
     */
    public function setProyecto($proyecto)
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    /**
     * Get proyecto
     *
     * @return \AppBundle\Entity\Proyecto
     */
    public function getProyecto()
    {
        return $this->proyecto;
    }

    /**
     * Set confirmado
     *
     * @param boolean $confirmado
     *
     * @return ProyectoFirma
     */
    public function setConfirmado($confirmado)
    {
        $this->confirmado = $confirmado;

        return $this;
    }

    /**
     * Get confirmado
     *
     * @return boolean
     */
    public function getConfirmado()
    {
        return $this->confirmado;
    }

    /**
     * Set fechaConfirmacion
     *
     * @param \DateTime $fechaConfirmacion
     *
     * @return ProyectoFirma
     */
    public function setFechaConfirmacion($fechaConfirmacion)
    {
        $this->fechaConfirmacion = $fechaConfirmacion;

        return $this;
    }

    /**
     * Get fechaConfirmacion
     *
     * @return \DateTime
     */
    public function getFechaConfirmacion()
    {
        return $this->fechaConfirmacion;
    }
    
}
