<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * Dictamen
 * 
 * @ORM\Table(name="dictamen",  indexes={@ORM\Index(name="dictamen_tipoNumeroDictamen_idx", columns={"idTipoNumeroDictamen"}),
 * 										 @ORM\index(name="dictamen_proyectoRevision_idx",columns={"idProyectoRevision"}),
 * 										 @ORM\index(name="dictamen_tipoProyecto_idx",columns={"idTipoDictamen"})
 * 										})
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminador", type="string", length=15)
 * @ORM\DiscriminatorMap({"basico" = "AppBundle\Entity\Dictamen", 
 *                        "articulado" = "AppBundle\Entity\DictamenArticulado"})
 */
class Dictamen
{
    //------------------------------atributos de la clase-----------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idDictamen", type="int")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\TipoNumeroDictamen
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoNumeroDictamen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTipoNumeroDictamen", referencedColumnName="idTipoNumeroDictamen")
     * })
     */
    private $tipoNumeroDictamen;
    
    /**
     * @var string
     * @ORM\Column(name="textoLibre",type="text",nullable=true)
     */
    private $textoLibre;
    
    /**
     * @var \AppBundle\Entity\ProyectoRevision
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\ProyectoRevision")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProyectoRevision",referencedColumnName="idProyectoRevision")
     * })
     */
    private $revisionDictamen;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PerfilLegislador")
     * @JoinTable(name="dictamen_legislador",
     * 			 joinColumns={@ORM\JoinColumn(name="idDictamen", referencedColumnName="idDictamen")},
     * 			 inverseJoinColumns={@ORM\JoinColumn(name="idPerfil", referencedColumnName="idPerfil")}
     * 			 )
     */
    private $concejales;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ExpedienteComision", mappedBy="dictamen",
     * 				  cascade={"persist"})
     */
    private $asignacionesDeEstudio;

    /**
     * @var string
     *
     * @ORM\Column(name="usuarioCreacion", length="70", type="string", nullable=false)
     */
    private $usuarioCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;

    //-------------------------------------setters y getters------------------------------------

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
     * Set tipoNumeroDictamen
     *
     * @param \AppBundle\Entity\TipoNumeroDictamen $tipoNumeroDictamen
     *
     * @return Dictamen
     */
    public function setTipoNumeroDictamen(\AppBundle\Entity\TipoNumeroDictamen $tipoNumeroDictamen= null)
    {
    	$this->tipoNumeroDictamen= $tipoNumeroDictamen;

        return $this;
    }

    /**
     * Get tipoNumeroDictamen
     *
     * @return \AppBundle\Entity\TipoNumeroDictamen
     */
    public function getTipoNumeroDictamen()
    {
        return $this->tipoNumeroDictamen;
    }
    
    /**
     * Get textoLibre
     *
     * @return string
     */
    public function getTextoLibre() {
    	return $this->textoLibre;
    }
    
    /**
     * Set textoLibre
     *
     * @param string $textoLibre
     *
     * @return Dictamen
     */
    public function setTextoLibre($textoLibre) {
    	$this->textoLibre = $textoLibre;
    	return $this;
    }
    
    /**
     * Set revisionDictamen
     *
     * @param \AppBundle\Entity\ProyectoRevision $proyectoRevision
     *
     * @return Dictamen
     */
    public function setRevisionDisctamen(\AppBundle\Entity\ProyectoRevision $proyectoRevision= null)
    {
    	$this->revisionDictamen= $proyectoRevision;
    	
    	return $this;
    }
    
    /**
     * Get revisionDictamen
     *
     * @return \AppBundle\Entity\ProyectoRevision
     */
    public function getRevisionDisctamen()
    {
    	return $this->revisionDictamen;
    }
    
    /**
     * set concejales
     *
     * @param array $nuevosConcejales
     *
     * @return Dictamen
     */
    public function setConcejales($nuevosConcejales)
    {
    	$collection= new \Doctrine\Common\Collections\ArrayCollection();
    	foreach ($nuevosConcejales as $concejal) {
    		$collection[]=$concejal;
    	}
    	$this->concejales = $collection;
    	
    	return $this;
    }
    
    /**
     * Add concejal
     *
     * @param \AppBundle\Entity\Perfil $concejal
     *
     * @return Dictamen
     */
    public function addConcejal(\AppBundle\Entity\PerfilLegislador $concejal)
    {
    	$this->concejales[] = $concejal;
    	
    	return $this;
    }
    
    /**
     * Remove concejal
     *
     * @param \AppBundle\Entity\PerfilLegislador $concejal
     *
     * @return Proyecto
     */
    public function removeConcejal(\AppBundle\Entity\PerfilLegislador $concejal)
    {
    	$this->concejales->removeElement($concejal);
    	return $this;
    }
    
    /**
     * Get concejales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConcejales()
    {
    	return $this->concejales;
    }
    
    /**
     * Add asignacionDeEstudio
     *
     * @param \AppBundle\Entity\ExpedienteComision $asignacionDeEstudio
     *
     * @return Dictamen 
     */
    public function addAsignacionDeEstudio(\AppBundle\Entity\ExpedienteComision $asignacionDeEstudio)
    {
    	$asignacionDeEstudio->setDictamen($this);
    	$this->asignacionesDeEstudio[] = $asignacionDeEstudio;
    	
    	return $this;
    }
    
    /**
     * Remove asignacionDeEstudio
     *
     * @param \AppBundle\Entity\ExpedienteComision $asignacionDeEstudio
     */
    public function removeAsignacionDeEstudio(\AppBundle\Entity\ExpedienteComision $asignacionDeEstudio)
    {
    	$this->asignacionesDeEstudio->removeElement($asignacionDeEstudio);
    }
    
    /**
     * Get expedienteAsignado
     *
     * @return \Doctrine\Common\Collections\Collection
     * @Exclude()
     */
    public function getAsignacionDeEstudio()
    {
    	return $this->asignacionesDeEstudio;
    }
   
    /**
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     *
     * @return Dictamen
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return ProyectoAsignado
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

    //------------------------------Propiedades virtuales-----------------------------------------
    
    /**
     * get claseDictamen
     * 
     * @return string
     * @VirtualProperty()
     */
    public function getClaseDictamen(){
    	return "basico";
    }
    
    /**
     * get comisiones
     *
     * @return array
     * @VirtualProperty()
     */
    public function getComisiones(){
    	$comisiones=[];
    	$asignaciones=$this->getAsignacionDeEstudio();
    	foreach ($asignaciones as $asignacion){
    		$comisiones[]=$asignacion->getComision();
    	}
    	return $comisiones;
    }
}
