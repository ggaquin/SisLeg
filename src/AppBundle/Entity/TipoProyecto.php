<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoProyecto
 *
 * @ORM\Table(name="tipoProyecto", indexes={@ORM\Index(name="tipoproyecto_tipoexpediente_idx", columns={"idTipoExpediente"})})
 * @ORM\Entity
 */
class TipoProyecto
{
    //-------------------------------Atributos de la clase----------------------------------------
    
    /**
     * @var integer
     *
     * @ORM\Column(name="idTipoProyecto", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoProyecto", type="string", length=30, nullable=false)
     */
    private $tipoProyecto;

     /**
     * @var \AppBundle\Entity\TipoExpediente
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoExpediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTipoExpediente", referencedColumnName="idTipoExpediente")
     * })
     */
    private $tipoExpediente;

   
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
     * Set tipoProyecto
     *
     * @param string $tipoProyecto
     *
     * @return TipoProyecto
     */
    public function setTipoProyecto($tipoProyecto)
    {
        $this->tipoProyecto = $tipoProyecto;

        return $this;
    }

    /**
     * Get tipoProyecto
     *
     * @return string
     */
    public function getTipoProyecto()
    {
        return $this->tipoProyecto;
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
    
}
