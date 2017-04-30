<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Comision
 *
 * @ORM\Table(name="Comision",indexes={@ORM\Index(name="comision_tipoC  omision_idx", columns={"idTipoComision"})})
 * @ORM\Entity
 */
class Comision
{
    //----------------------------------atributos de la clase------------------------------------
	
    /**
     * @var integer
     *
     * @ORM\Column(name="idComision", type="int")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PerfilLegislador", mappedBy="comisiones")
     */
	private $integrantes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ExpedienteComision", mappedBy="comision")
     */
	private $expedientesAsignados;

    /**
     * @var string
     *
     * @ORM\Column(name="comision", type="string", length=100, nullable=false)
     */
    private $comision;

     /**
     * @var \AppBundle\Entity\TipoComision
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoComision")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTipoComision", referencedColumnName="idTipoComision")
     * })
     */
    private $tipoComision;

      /**
     * @var boolean
     *
     * @ORM\Column(name="activa", type="boolean", nullable=false)
     */
    private $activa;


    //------------------------------------constructor--------------------------------------------

     /**
     * Constructor
     */
    public function __construct()
    {
        $this->expedientesAsignados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->integrantes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    //-------------------------------------setters y getters-------------------------------------

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
     * Add integrante
     *
     * @param \AppBundle\Entity\PerfilLegislador $integrante
     *
     * @return Comision
     */
    public function addIntegrante(\AppBundle\Entity\PerfilLegislador $integrante)
    {
        $this->integrantes[] = $integrante;

        return $this;
    }

    /**
     * Remove integrante
     *
     * @param \AppBundle\Entity\PerfilLegislador $integrante
     */
    public function removeIntegrante(\AppBundle\Entity\PerfilLegislador $integrante)
    {
        $this->integrantes->removeElement($integrante);
    }

    /**
     * Get integrantes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIntegrantes()
    {
        return $this->integrantes;
    }

    /**
     * Add expedienteAsignado
     *
     * @param \AppBundle\Entity\ExpedienteComision $expedienteAsignado
     *
     * @return Comision
     */
    public function addExpedienteAsignado(\AppBundle\Entity\ExpedienteComision $expedienteAsignado)
    {
        $this->expedientesAsignados[] = $expedienteAsignado;

        return $this;
    }

    /**
     * Remove expedienteAsignado
     *
     * @param \AppBundle\Entity\ExpedienteComision $expedienteAsignado
     */
    public function removeExpedienteAsignado(\AppBundle\Entity\ExpedienteComision $expedienteAsignado)
    {
        $this->expedientesAsignados->removeElement($expedienteAsignado);
    }

    /**
     * Get expedienteAsignado
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExpedientesAsignados()
    {
        return $this->expedientesAsignados;
    }

    /**
     * Set comision
     *
     * @param string $comision
     *
     * @return Comision
     */
    public function setComision($comision)
    {
        $this->comision = $comision;

        return $this;
    }

    /**
     * Get comision
     *
     * @return string
     */
    public function getComision()
    {
        return $this->comision;
    }

    /**
     * Set tipoComision
     *
     * @param \AppBundle\Entity\TipoComision $tipoComision
     *
     * @return Comision
     */
    public function setTipoComision(\AppBundle\Entity\TipoComision $tipoComision = null)
    {
        $this->tipoComision = $tipoComision;

        return $this;
    }

    /**
     * Get tipoComision
     *
     * @return \AppBundle\Entity\TipoComision
     */
    public function getTipoComision()
    {
        return $this->tipoComision;
    }

    /**
     * Set activa
     *
     * @param boolean $activa
     *
     * @return Comision
     */
    public function setActiva($activa)
    {
        $this->activa = $activa;

        return $this;
    }

    /**
     * Get activa
     *
     * @return boolean
     */
    public function getActiva()
    {
        return $this->activa;
    }

    //------------------------------Propiedades virtuales-----------------------------------------

    /**
     * Get listaIntegrantes
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getListaIntegrantes()
    {
        $integrantes=$this->integrantes;
        $listaIntegrantes="";
        foreach ($integrantes as $integrante) {
            $listaIntegrantes.=($listaIntegrantes!=""?"-":"").$integrante->getNombreCompleto();
        }
        return $listaIntegrantes;
    }
}
