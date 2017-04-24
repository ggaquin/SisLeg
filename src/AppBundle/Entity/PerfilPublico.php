<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * PerfilPublico
 * @ORM\Entity
 */
class PerfilPublico extends Perfil
{

    //---------------------------------atributos de la clase----------------------------------------

    /**
     * @var string
     *
     * @ORM\Column(name="muneroDocumento", type="integer", nullable=true)
     */
    private $muneroDocumento;

    /**
     * @var string
     *
     * @ORM\Column(name="domicilio", type="string", length=100, nullable=true)
     */
    private $domicilio;

    //-----------------------------------getters y setters-----------------------------------------

    /**
     * Set numeroDocumento
     *
     * @param integer $numeroDocumento
     *
     * @return PerfilPublico
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;

        return $this;
    }

    /**
     * Get numeroDocumento
     *
     * @return integer
     */
    public function getNumeroDocumentoo()
    {
        return $this->numeroDocumento;
    }

    /**
     * Set domicilio
     *
     * @param string $domicilio
     *
     * @return PerfilPublico
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string
     */
    public function getDomicilio()
    {
        return $this->domicilio;
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
        return "publico";
    }

}
