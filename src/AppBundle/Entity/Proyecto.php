<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation\VirtualProperty;
use Doctrine\ORM\Mapping as ORM;


/**
 * Proyecto
 * @ORM\Table(name="proyecto", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_proyecto_expediente_idx",
 *                                                 columns={"idExpediente"})},
 *                             indexes={@ORM\Index(name="proyecto_tipoProyecto_idx", columns={"idTipoProyecto"}),
 *                                      @ORM\Index(name="proyecto_concejal_idx", columns={"idConcejal"})
 *                                     }
 *                              )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProyectoRepository")
 */
class Proyecto
{
    //-----------------------------------------atributos de la clase-------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idProyecto", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Expediente
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Expediente", inversedBy="proyecto", fetch="EAGER" )
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="idExpediente", referencedColumnName="idExpediente")
     * })
     */
     private $expediente;

    /**
     * @var \AppBundle\Entity\TipoProyecto
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoProyecto", fetch="EAGER" )
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="idTipoProyecto", referencedColumnName="idTipoProyecto")
     * })
     */
     private $tipoProyecto;
     
     /**
      * @var string
      * 
      * @ORM\Column(name="clavesBusqueda", type="string", length=120, nullable=false)
      */
     private $clavesBusqueda;

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

    /*
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Perfil", fetch="EAGER", orphanRemoval=true )
     * @ORM\JoinTable(name="legisladores_proyectos",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idProyecto", referencedColumnName="idProyecto")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idPerfil", referencedColumnName="idPerfil")
     *   }
     * )
     *
    private $concejales;
    */

    /**
     * @var \AppBundle\Entity\PerfilLegislador
     *
     * @ORM\ManyToone(targetEntity="AppBundle\Entity\Perfil", fetch="LAZY")
     *@ORM\JoinColumns({
     *	@ORM\JoinColumn(name="idConcejal", referencedColumnName="idPerfil")
     *})
     *
     */
    private $concejal;
    
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
     * @ORM\Column(name="usuarioModificacion", type="string", length=70,nullable=true)
     */
    private $usuarioModificacion;
    

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
     * Set expediente
     *
     * @param string $expediente
     *
     * @return Proyecto
     */
    public function setExpediente($expediente)
    {
        $this->expediente = $expediente;

        return $this;
    }

    /**
     * Get expediente
     *
     * @return string
     */
    public function getExpediente()
    {
        return $this->expediente;
    }

    /**
     * Set tipoProyecto
     *
     * @param \AppBundle\Entity\TipoProyecto $tipoProyecto
     *
     * @return Proyecto
     */
    public function setTipoProyecto($tipoProyecto)
    {
        $this->tipoProyecto = $tipoProyecto;

        return $this;
    }

    /**
     * Get tipoProyecto
     *
     * @return \AppBundle\Entity\TipoProyecto
     */
    public function getTipoProyecto()
    {
        return $this->tipoProyecto;
    }
    
    /**
     * Get clavesBusqueda
     * 
     * @return string
     */
	public function getClavesBusqueda() {
		return $this->clavesBusqueda;
	}
	
	/**
	 * Set clavesBusqueda
	 * 
	 * @param string $clavesBusqueda
	 * 
	 * @return Proyecto
	 */
	public function setClavesBusqueda($clavesBusqueda) {
		$this->clavesBusqueda = $clavesBusqueda;
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
     * Get concejal
     * 
     * @return \AppBundle\Entity\PerfilLegislador
     */
	public function getConcejal() {
		return $this->concejal;
	}
	
	/**
	 * Set concejal
	 * @param \AppBundle\Entity\PerfilLegislador $concejal
	 * @return Proyecto
	 */
	public function setConcejal($concejal) {
		$this->concejal = $concejal;
		return $this;
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
     * Get fechaEntradaFormateada
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getFechaEntradaFormateada()
    {
        return ((!is_null($this->expediente))
                    ?$this->expediente->getFechaCreacion()->format('d-m-Y')
                    :"---");
    }

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

    /**
     * Get numeroExpediente
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getNumeroExpediente()
    {
        return ((!is_null($this->expediente))
                    ?$this->expediente->getNumeroCompleto()
                    :"---");
    }

    /**
     * Get estadoExpediente
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getEstadoExpediente()
    {
        return ((!is_null($this->expediente))
                    ?$this->expediente->getEstadoExpediente()->getEstadoExpediente()
                    :"---");
    }
}
