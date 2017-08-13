<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Comision
 *
 * @ORM\Table(name="Comision",indexes={@ORM\Index(name="comision_tipoComision_idx", columns={"idTipoComision"}),
                                       @ORM\Index(name="comision_perfilPresidente_idx", columns={"idPerfilPresidente"}),
                                       @ORM\Index(name="comision_perfilVicePresidente_idx", columns={"idPerfilVicePresidente"})
                                       })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComisionRepository")
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
     * @var \AppBundle\Entity\PerfilLegislador
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PerfilLegislador",fetch="EAGER" )
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="idPerfilPresidente", referencedColumnName="idPerfil")
     * })
     */
    private $presidente;

    /**
     * @var \AppBundle\Entity\PerfilLegislador
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PerfilLegislador",fetch="EAGER" )
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="idPerfilVicePresidente", referencedColumnName="idPerfil")
     * })
     */
    private $vicePresidente;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PerfilLegislador",orphanRemoval=true)
     * @ORM\JoinTable(name="comision_legisladorTitular",
     *      joinColumns={@ORM\JoinColumn(name="idComision", referencedColumnName="idComision")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="idPerfil", referencedColumnName="idPerfil")}
     *      )
     */
	private $titulares;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PerfilLegislador",orphanRemoval=true)
     * @ORM\JoinTable(name="comision_legisladorSuplente",
     *      joinColumns={@ORM\JoinColumn(name="idComision", referencedColumnName="idComision")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="idPerfil", referencedColumnName="idPerfil")}
     *      )
     */
    private $suplentes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ExpedienteComision", mappedBy="comision", 
     * 				  cascade={"persist", "remove"},orphanRemoval=true)
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
    
    /**
     * @var string
     *
     * @ORM\Column(name="usuarioCreacion", type="string", length=70, nullable=false)
     */
    private $usuarioCreacion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="usuarioModificacion", type="string", length=70, nullable=true)
     */
    private $usuarioModificacion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificacion", type="datetime", nullable=true)
     */
    private $fechaModificacion;


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
     * Set presidente
     *
     * @param \AppBundle\Entity\PerfilLegislador $presidente
     *
     * @return Comision
     */
    public function setPresidente(\AppBundle\Entity\PerfilLegislador $presidente = null)
    {
        $this->presidente = $presidente;

        return $this;
    }

    /**
     * Get presidente
     *
     * @return \AppBundle\Entity\PerfilLegislador
     */
    public function getPresidente()
    {
        return $this->presidente;
    }

    /**
     * Set vicePresidente
     *
     * @param \AppBundle\Entity\PerfilLegislador $vicePresidente
     *
     * @return Comision
     */
    public function setVicePresidente(\AppBundle\Entity\PerfilLegislador $vicePresidente = null)
    {
        $this->vicePresidente = $vicePresidente;

        return $this;
    }

    /**
     * Get vicePresidente
     *
     * @return \AppBundle\Entity\PerfilLegislador
     */
    public function getVicePresidente()
    {
        return $this->vicePresidente;
    }

    /**
     * Add titular
     *
     * @param \AppBundle\Entity\PerfilLegislador $titular
     *
     * @return Comision
     */
    public function addTitular(\AppBundle\Entity\PerfilLegislador $titular)
    {
        $this->titulares[] = $titular;

        return $this;
    }

    /**
     * Remove titular
     *
     * @param \AppBundle\Entity\PerfilLegislador $titular
     */
    public function removeTitular(\AppBundle\Entity\PerfilLegislador $titular)
    {
        $this->titulares->removeElement($titular);
    }

    /**
     * Get Titulares
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTitulares()
    {
        return $this->titulares;
    }

    /**
     * Set Titulares
     *
     * @param array $titulares
     *
     * @return Comision
     */
    public function setTitulares($nuevosTitulares)
    {
        $collection= new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($nuevosTitulares as $titular) {
            $collection[]=$titular;
        }
        $this->titulares = $collection;
    }

    /**
     * Add suplente
     *
     * @param \AppBundle\Entity\PerfilLegislador $suplente
     *
     * @return Comision
     */
    public function addSuplente(\AppBundle\Entity\PerfilLegislador $suplente)
    {
        $this->suplentes[] = $suplente;

        return $this;
    }

    /**
     * Remove suplente
     *
     * @param \AppBundle\Entity\PerfilLegislador $suplente
     */
    public function removeSuplente(\AppBundle\Entity\PerfilLegislador $suplente)
    {
        $this->suplentes->removeElement($suplente);
    }

    /**
     * Get suplentes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSuplentes()
    {
        return $this->suplentes;
    }

    /**
     * Set suplentes
     *
     * @param array $suplentes
     *
     * @return Comision
     */
    public function setSuplentes($nuevosSuplentes)
    {
        $collection= new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($nuevosSuplentes as $suplente) {
            $collection[]=$suplente;
        }
        $this->suplentes = $collection;
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
        $expedienteAsignado->setExpediente($this);
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
    
    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Comision
     */
    public function setFechaCreacion($fechaCreacion)
    {
    	$this->fechaCreacion = $fechaCreacion;
    	
    	return $this;
    }
    
    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
    	return $this->fechaCreacion;
    }
    
    /**
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     *
     * @return Comision
     */
    public function setUsuarioCreacion($usuarioCreacion)
    {
    	$this->usuarioCreacion = $usuarioCreacion;
    	
    	return $this;
    }
    
    /**
     * Get usuarioCreacion
     *
     * @return string
     */
    public function getUsuarioCreacion()
    {
    	return $this->usuarioCreacion;
    }
    
    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     *
     * @return Comision
     */
    public function setFechaModificacion($fechaModificacion)
    {
    	$this->fechaModificacion = $fechaModificacion;
    	
    	return $this;
    }
    
    /**
     * Get fechaModificacion
     *
     * @return \DateTime
     */
    public function getFechaModificacion()
    {
    	return $this->fechaModificacion;
    }
    
    /**
     * Set usuarioModificacion
     *
     * @param string $usuarioModificacion
     *
     * @return Comision
     */
    public function setUsuarioModificacion($usuarioModificacion)
    {
    	$this->usuarioModificacion = $usuarioModificacion;
    	
    	return $this;
    }
    
    /**
     * Get usuarioModificacion
     *
     * @return string
     */
    public function getUsuarioModificacion()
    {
    	return $this->usuarioModificacion;
    }

    //------------------------------Propiedades virtuales-----------------------------------------

    /**
     * Get listaTitulares
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getListaTitulares()
    {
        $titulares=$this->titulares;
        $listaTitulares="";
        foreach ($titulares as $titular) {
            $listaTitulares.=($listaTitulares!=""?"-":"").$titular->getNombreCompleto();
        }
        return $listaTitulares;
    }

     /**
     * Get listaSuplentes
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getListaSuplentes()
    {
        $suplentes=$this->suplentes;
        $listaSuplentes="";
        foreach ($suplentes as $suplente) {
            $listaSuplentes.=($listaSuplentes!=""?"-":"").$suplente->getNombreCompleto();
        }
        return $listaSuplentes;
    }
}
