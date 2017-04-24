<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoVoto
 *
 * @ORM\Table(name="tipoVoto")
 * @ORM\Entity
 */
class TipoVoto
{
    //--------------------------------------atributos de la clase---------------------------------
    
    /**
     * @var integer
     *
     * @ORM\Column(name="idTipoVoto", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoVoto", type="string", length=45, nullable=false)
     */
    private $tipoVoto;

    //------------------------------------setters y getters---------------------------------------

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
     * Set tipoVoto
     *
     * @param string $tipoVoto
     *
     * @return TipoVoto
     */
    public function setTipoVoto($tipoVoto)
    {
        $this->tipoVoto = $tipoVoto;

        return $this;
    }

    /**
     * Get tipoVoto
     *
     * @return string
     */
    public function getTipoVoto()
    {
        return $this->tipoVoto;
    }
}
