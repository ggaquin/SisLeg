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
