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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bloque")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idBloque", referencedColumnName="idBloque")
     * })
     */
    private $bloque;

    /**
     * @var string
     *
     * @ORM\Column(name="oficina", type="string", length=50, nullable=false)
     */
    private $oficina;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Comision", mappedBy="integrantes")
     */
    private $comisiones;

    //-------------------------------------constructor-------------------------------------------

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comisiones = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add comision
     *
     * @param \AppBundle\Entity\Comision $comision
     *
     * @return PerfilLegislador
     */
    public function addComision(\AppBundle\Entity\Comision $comision)
    {
        $comision->addIntegrante($this);
        return $this;
    }

    /**
     * Remove comision
     *
     * @param \AppBundle\Entity\Comision $comision
     */
    public function removeComision(\AppBundle\Entity\Comision $comision)
    {
        $comision->removeIntegrante($this);
        return $this;
    }

    /**
     * Get Comisiones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComisiones()
    {
        return $this->comisiones;
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
}
