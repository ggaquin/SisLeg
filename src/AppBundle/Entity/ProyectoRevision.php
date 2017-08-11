<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation\VirtualProperty;
use Doctrine\ORM\Mapping as ORM;


/**
 * ProyectoRevision
 * @ORM\Table(name="proyectoRevision", indexes={@ORM\Index(name="proyectoRevision_proyecto_idx", columns={"idProyecto"}),
 *                                     			@ORM\Index(name="proyectoRevision_oficina_idx", columns={"idOficina"})
 *                                     			}
 *           )
 * @ORM\Entity
 */
class ProyectoRevision
{
    //-----------------------------------------atributos de la clase-------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idProyectoRevision", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Proyecto
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Proyecto", fetch="LAZY")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="idProyecto", referencedColumnName="idProyecto")
     * })
     */
     private $proyecto;

    /**
     * @var \AppBundle\Entity\Oficina
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Oficina", fetch="LAZY" )
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="idOficina", referencedColumnName="idOficina")
     * })
     */
     private $oficina;
     
     /**
      * @var boolean
      *
      * @ORM\Column(name="incluyeVistosYConsiderandos", type="boolean", nullable=false)
      */
     private $incluyeVistosYConsiderandos;
     
    /**
     * @var text
     *
     * @ORM\Column(name="visto", type="text", nullable=false)
     */
    private $visto;

    /**
     * @var text
     *
     * @ORM\Column(name="considerandos", type="text", nullable=false)
     */
    private $considerandos;

    /**
     * @var array
     *
     * @ORM\Column(name="articulos", type="json_array", nullable=false)
     */
    private $articulos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;


    /**
     * @var string
     *
     * @ORM\Column(name="usuarioCreacion", type="string", length=70, nullable=false)
     */
    private $usuarioCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificacion", type="datetime", nullable=true)
     */
    private $fechaModificacion;


    /**
     * @var string
     *
     * @ORM\Column(name="usuarioModificacion", type="string", length=70, nullable=false)
     */
    private $usuarioModificacion;
    
    //------------------------------------constructor---------------------------------------------
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->incluyeVistosYConsiderandos=true;
    }
    

    //-------------------------------------setters y getters--------------------------------------
 
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
     * Set id
     *
     * @param integer $id
     *
     * @return ProyectoRevision
     */
    public function setId($id)
    {
    	return $this->id=$id;
    }
    
    /**
     * Set proyecto
     *
     * @param string $proyecto
     *
     * @return ProyectoRevision
     */
    public function setProyecto($proyecto)
    {
    	$this->proyecto= $proyecto;

        return $this;
    }

    /**
     * Get proyecto
     *
     * @return string
     */
    public function getProyecto()
    {
    	return $this->proyecto;
    }

    /**
     * Set oficina
     *
     * @param \AppBundle\Entity\Oficina $oficina
     *
     * @return ProyectoRevision
     */
    public function setOficina($oficina)
    {
    	$this->oficina = $oficina;

        return $this;
    }

    /**
     * Get oficina
     *
     * @return \AppBundle\Entity\Oficina
     */
    public function getOficina()
    {
        return $this->oficina;
    }
    
    /**
     * Get ncluyeVistosYConsiderandos
     * 
     * @return boolean
     */
	public function getIncluyeVistosYConsiderandos() {
		return $this->incluyeVistosYConsiderandos;
	}
	
	/**
	 * Set ncluyeVistosYConsiderandos
	 * @param boolean $incluyeVistosYConsiderandos
	 * @return ProyectoRevision
	 */
	public function setIncluyeVistosYConsiderandos($incluyeVistosYConsiderandos) {
		$this->incluyeVistosYConsiderandos = $incluyeVistosYConsiderandos;
		return $this;
	}
	
    /**
     * Set visto
     *
     * @param text $visto
     *
     * @return Proyecto
     */
    public function setVisto($visto)
    {
        $this->visto = $visto;

        return $this;
    }

    /**
     * Get visto
     *
     * @return text
     */
    public function getVisto()
    {
        return $this->visto;
    }

    /**
     * Set considerandos
     *
     * @param text $considerandos
     *
     * @return Proyecto
     */
    public function setConsiderandos($considerandos)
    {
        $this->considerandos = $considerandos;

        return $this;
    }

    /**
     * Get considerandos
     *
     * @return text
     */
    public function getConsiderandos()
    {
        return $this->considerandos;
    }

    /**
     * Set articulos
     *
     * @param array $articulos
     *
     * @return Proyecto
     */
    public function setArticulos($articulos)
    {
        $this->articulos = $articulos;

        return $this;
    }

    /**
     * Get articulos
     *
     * @return array
     */
    public function getArticulos()
    {
        return $this->articulos;
    } 

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Perfil
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
     * Get usuarioCreacion
     *
     * @return string
     */
    public function getUsuarioCreacion()
    {
        return $this->usuarioCreacion;
    }

    /**
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     *
     * @return Perfil
     */
    public function setUsuarioCreacion($usuarioCreacion)
    {
        $this->usuarioCreacion = $usuarioCreacion;

        return $this;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     *
     * @return Perfil
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
     * Get usuarioModificacion
     *
     * @return string
     */
    public function getUsuarioModificacion()
    {
        return $this->usuarioModificacion;
    }

    /**
     * Set usuarioModificacion
     *
     * @param string $usuarioModificacion
     *
     * @return Perfil
     */
    public function setUsuarioModificacion($usuarioModificacion)
    {
        $this->usuarioModificacion = $usuarioModificacion;

        return $this;
    }

    //------------------------------Propiedades virtuales-----------------------------------------

    /**
     * Get fechaCreacionFormateada
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getFechaCreacionFormateada()
    {
        return $this->fechaCreacion->format('d-m-Y');
    }

}
