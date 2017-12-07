<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * Sancion
 * 
 * @ORM\Table(name="sancion",  indexes={@ORM\Index(name="sancion_encabezadoRedaccion_idx",columns={"idEncabezadoRedaccion"}),
 * 										@ORM\Index(name="sancion_pieRedaccion_idx",columns={"idPieRedaccion"}),
 * 										@ORM\Index(name="sancion_proyectoRevision_idx",columns={"idProyectoRevision"}),
 * 									    @ORM\Index(name="sancion_tipoSancion_idx",columns={"idTiposancion"}),
 * 									    @ORM\Index(name="sancion_dictamen_idx",columns={"idDictamen"}),
 * 										@ORM\Index(name="sancion_pase_idx",columns={"idPase"})
 * 										})
 * 
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminador", type="string", length=17)
 * @ORM\DiscriminatorMap({"basica" = "AppBundle\Entity\SancionBasica",
 * 						  "articulado" = "AppBundle\Entity\SancionArticulada",
 * 						  "revision" = "AppBundle\Entity\SancionRevisionProyecto"})
 */

// @ORM\Index(name="sancion_proyectoRevision_idx",columns={"idProyectoRevision"}),
//  										   @ORM\Index(name="sancion_tipoSancion_idx",columns={"idTiposancion"}),
//  										   @ORM\Index(name="sancion_dictamen_idx",columns={"idDictamen"}),
// 										   @ORM\Index(name="sancion_pase_idx",columns={"idPase"}),
abstract class Sancion
{
    //------------------------------atributos de la clase-----------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idSancion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var \AppBundle\Entity\Dictamen
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Dictamen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idDictamen",referencedColumnName="idDictamen")
     * })
     */
    private $dictamen;
        
    /**
     * @var string
     * @ORM\Column(name="textoLibre",type="text",nullable=true)
     */
    private $textoLibre;
    
    /**
     * @var \AppBundle\Entity\PlantillaTexto
     * 
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\PlantillaTexto")
     * @ORM\JoinColumn(name="idEncabezadoRedaccion", referencedColumnName="idPlantillaTexto")
     */
    private $encabezadoRedaccion;
    
    /**
     * @var \AppBundle\Entity\PlantillaTexto
     * 
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\PlantillaTexto")
     * @ORM\JoinColumn(name="idPieRedaccion", referencedColumnName="idPlantillaTexto")
     */
    private $pieRedaccion;
	
    /**
     * @var string
     *
     * @ORM\Column(name="usuarioCreacion", length=70, type="string", nullable=false)
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
     * Get dictamen
     * 
     * @return Dictamen
     */
	public function getDictamen() {
		return $this->dictamen;
	}
	
	/**
	 * Set Dictamen
	 * 
	 * @param \AppBundle\Entity\Dictamen $dictamen
	 * @return Sancion
	 */
	public function setDictamen($dictamen) {
		$this->dictamen = $dictamen;
		return $this;
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
	 * @return Sancion
	 */
	public function setTextoLibre($textoLibre) {
		$this->textoLibre = $textoLibre;
		return $this;
	}
	
	/**
	 * Get encabezadoRedaccion
	 * 
	 * @return PlantillaTexto
	 */
	public function getEncabezadoRedaccion() {
		return $this->encabezadoRedaccion;
	}
	
	/**
	 * Set encabezadoRedaccion
	 * 
	 * @param \AppBundle\Entity\PlantillaTexto $encabezadoRedaccion
	 * @return Sancion
	 */
	public function setEncabezadoRedaccion($encabezadoRedaccion) {
		$this->encabezadoRedaccion = $encabezadoRedaccion;
		return $this;
	}
	
	/**
	 * Get pieRedaccion
	 * 
	 * @return PlantillaTexto
	 */
	public function getPieRedaccion() {
		return $this->pieRedaccion;
	}
	
	/**
	 * Set pieRedaccion
	 * 
	 * @param \AppBundle\Entity\PlantillaTexto $pieRedaccion
	 * @return \AppBundle\Entity\Sancion
	 */
	public function setPieRedaccion($pieRedaccion) {
		$this->pieRedaccion = $pieRedaccion;
		return $this;
	}
		       
    /**
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     *
     * @return Sancion
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
     * @return Sancion
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
     * get claseSancion
     * 
     * @return string
     * @VirtualProperty()
     */
    public abstract function getClaseSancion();
      
}
