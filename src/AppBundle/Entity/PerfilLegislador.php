<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * PerfilLegislador
 * @ORM\Entity
 */
class PerfilLegislador extends Perfil
{
    //---------------------------------atributos de la clase--------------------------------------

    /**
     * @var \AppBundle\Entity\Bloque
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bloque", inversedBy="concejales")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idBloque", referencedColumnName="idBloque")
     * })
     */
    private $bloque;

    /**
     * @var string
     *
     * @ORM\Column(name="oficina", type="string", length=50, nullable=true)
     */
    private $oficina;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="desde", type="datetime", nullable=false)
     */
    private $desde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="desde", type="datetime", nullable=false)
     */
    private $hasta;

    //--------------------------------------getters y setters-------------------------------------
    
    /**
     * Set bloque
     *
     * @param \AppBundle\Entity\Bloque $bloque
     *
     * @return PerfilLegislador
     */
    public function setBloque($bloque)
    {
        $this->bloque = $bloque;

        return $this;
    }

    /**
     * Get bloque
     *
     * @return \AppBundle\Entity\Bloque
     */
    public function getBloque()
    {
        return $this->bloque;
    }

      /**
     * Set oficina
     *
     * @param string $oficina
     *
     * @return PerfilLegislador
     */
    public function setOficina($oficina)
    {
        $this->oficina = $oficina;

        return $this;
    }

    /**
     * Get oficina
     *
     * @return string
     */
    public function getOficina()
    {
        return $this->oficina;
    }

    /**
     * Set desde
     *
     * @param \DateTime $desde
     *
     * @return PerfilLegislador
     */
    public function setDesde($desde)
    {
        $this->desde = $desde;

        return $this;
    }

    /**
     * Get desde
     *
     * @return \DateTime
     */
    public function getDesde()
    {
        return $this->desde;
    }

    /**
     * Set hasta
     *
     * @param \DateTime $hasta
     *
     * @return PerfilLegislador
     */
    public function setHasta($hasta)
    {
        $this->hasta = $hasta;

        return $this;
    }

    /**
     * Get hasta
     *
     * @return \DateTime
     */
    public function getHasta()
    {
        return $this->hasta;
    }

    //-------------------------------propiedades virtuales-----------------------------------------

    /**
     * Get tipoPerfil
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getTipoPerfil()
    {
        return "legislador";
    }

    /**
     * Get fechaDesdeFormateada
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getFechaDesdeFormateada()
    {
        return (is_null($this->getDesde())?'':$this->getDesde()->format('d/m/Y'));
    }

    /**
     * Get fechaHastaFormateada
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getFechaHastaFormateada()
    {
        return (is_null($this->getDesde())?'':$this->getHasta()->format('d/m/Y'));
    }

     /**
     * Get descripcion
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getDescripcion()
    {
        return parent::getNombreCompleto().' - ('.$this->bloque->getBloque().')';
    }
}
