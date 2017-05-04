<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PerfilExpedienteVoto
 *
 * @ORM\Table(name="PerfilExpedienteVoto", indexes={@ORM\Index(name="perfilExpedienteVoto_perfil_idx", columns={"idPerfil"}), 
*                                                   @ORM\Index(name="perfilExpedienteVoto_expediente_idx", columns={"idExpediente"}), 
*                                                   @ORM\Index(name="perfilExpedienteVoto_tipoVoto_idx", columns={"idTipoVoto"})})
 * @ORM\Entity
 */
class PerfilExpedienteVoto
{
    //------------------------------atributos de la clase-----------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idPerfilExpedienteVoto", type="integer")
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
    private $perfil;

    /**
     * @var \AppBundle\Entity\Expediente
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idExpediente", referencedColumnName="idExpediente")
     * })
     */
    private $expediente;

    /**
     * @var \AppBundle\Entity\TipoVoto
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoVoto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTipoVoto", referencedColumnName="idTipoVoto")
     * })
     */
    private $tipoVoto;



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
     * Set perfil
     *
     * @param \AppBundle\Entity\Perfil $perfil
     *
     * @return PerfilProyectoVoto
     */
    public function setPerfil(\AppBundle\Entity\Perfil $perfil = null)
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * Get perfil
     *
     * @return \AppBundle\Entity\Perfil
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * Set expediente
     *
     * @param \AppBundle\Entity\Expediente $expediente
     *
     * @return PerfilProyectoVoto
     */
    public function setExpediente(\AppBundle\Entity\Expediente $expediente = null)
    {
        $this->expediente = $expediente;

        return $this;
    }

    /**
     * Get expediente
     *
     * @return \AppBundle\Entity\Expediente
     */
    public function getExpediente()
    {
        return $this->expediente;
    }

    /**
     * Set tipoVoto
     *
     * @param \AppBundle\Entity\TipoVoto $tipoVoto
     *
     * @return PerfilProyectoVoto
     */
    public function setTipoVoto(\AppBundle\Entity\TipoVoto $tipoVoto = null)
    {
        $this->tipoVoto = $tipoVoto;

        return $this;
    }

    /**
     * Get tipoVoto
     *
     * @return \AppBundle\Entity\TipoVoto
     */
    public function getTipoVoto()
    {
        return $this->tipoVoto;
    }
}
