<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoComision
 *
 * @ORM\Table(name="tipoComision")
 * @ORM\Entity
 */
class TipoComision
{
    //--------------------------------------atributos de la clase---------------------------------
    
    /**
     * @var integer
     *
     * @ORM\Column(name="idTipoComision", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoComision", type="string", length=20, nullable=false)
     */
    private $tipoComision;

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
     * Set tipoComision
     *
     * @param string $tipoComision
     *
     * @return TipoComision
     */
    public function setTipoComision($tipoComision)
    {
        $this->tipoComision = $tipoComision;

        return $this;
    }

    /**
     * Get tipoComision
     *
     * @return string
     */
    public function getTipoComision()
    {
        return $this->tipoComision;
    }
}
