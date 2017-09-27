<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * Resolucion
 * 
 * @ORM\Table(name="resolucion",  indexes={@ORM\Index(name="resolucion_proyectoRevision_idx",columns={"idProyectoRevision"}),
 * 										   @ORM\Index(name="resolucion_notificacion_idx", columns={"idNotificacion"}),
 * 										   @ORM\Index(name="resolucion_tipoResolucion_idx",columns={"idTipoResolucion"}),
 * 										   @ORM\Index(name="resolucion_dictamen_idx",columns={"idDictamen"})
 * 										})
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminador", type="string", length=17)
 * @ORM\DiscriminatorMap({"basica" = "AppBundle\Entity\Resolucion", 
 *                        "articulada" = "AppBundle\Entity\ResolucionArticuladaConSancion",
 *                        "revision" = "AppBundle\Entity\ResolucionRevisionProyectoConSancion"})
 */
class Resolucion
{
    //------------------------------atributos de la clase-----------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idResolucion", type="integer")
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
     * @var boolean
     * @ORM\Column(name="modificaDictamen", type="boolean", nullable=false)
     */
    private $modificaDictamen=false;
    
    /**
     * @var string
     * @ORM\Column(name="textoLibre",type="text",nullable=true)
     */
    private $textoLibre;
	
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
	 * @return Resolucion
	 */
	public function setDictamen($dictamen) {
		$this->dictamen = $dictamen;
		return $this;
	}
	
	/**
	 * Get modificaDictamen
	 * 
	 * @return boolean
	 */
	public function getModificaDictamen() {
		return $this->modificaDictamen;
	}
	
	/**
	 * Set modificaDictamen
	 * 
	 * @param boolean $modificaDictamen
	 * @return Resolucion
	 */
	public function setModificaDictamen($modificaDictamen) {
		$this->modificaDictamen = $modificaDictamen;
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
	 * @return Resolucion
	 */
	public function setTextoLibre($textoLibre) {
		$this->textoLibre = $textoLibre;
		return $this;
	}
	       
    /**
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     *
     * @return Resolucion
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
     * @return Resolucion
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
     * get claseResolucion
     * 
     * @return string
     * @VirtualProperty()
     */
    public function getClaseResolucion(){
    	return "basica";
    }
      
}
