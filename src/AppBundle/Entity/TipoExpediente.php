<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoExpediente
 *
 * @ORM\Table(name="tipoExpediente")
 * @ORM\Entity
 */
class TipoExpediente
{
    //-------------------------------Atributos de la clase----------------------------------------
    
    /**
     * @var integer
     *
     * @ORM\Column(name="idTipoExpediente", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoExpediente", type="string", length=45, nullable=false)
     */
    private $tipoExpediente;

    /**
     * @var string
     *
     * @ORM\Column(name="letra", type="string", length=1, nullable=false)
     */
    private $letra;

   
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
     * Set tipoExpediente
     *
     * @param string $tipoExpediente
     *
     * @return TipoExpediente
     */
    public function setTipoExpediente($tipoExpediente)
    {
        $this->tipoExpediente = $tipoExpediente;

        return $this;
    }

    /**
     * Get tipoExpediente
     *
     * @return string
     */
    public function getTipoExpediente()
    {
        return $this->tipoExpediente;
    }

    /**
     * Set letra
     *
     * @param string $letra
     *
     * @return TipoExpediente
     */
    public function setLetra($letra)
    {
        $this->letra = $letra;

        return $this;
    }

    /**
     * Get letra
     *
     * @return string
     */
    public function getLetra()
    {
        return $this->letra;
    }

    
}
