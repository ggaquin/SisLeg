<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation\VirtualProperty;
use Doctrine\ORM\Mapping as ORM;

/**
 * Proyecto
 *
 * @ORM\Table(name="proyecto", indexes={@ORM\Index(name="UNIQ_proyecto_expediente_idx", columns={"idExpediente"}), 
 *                                      @ORM\Index(name="fk_proyecto_tipoProyecto_idx", columns={"idTipoProyecto"})
 *                                     })
 * @ORM\Entity
 */
class Proyecto
{
    //-----------------------------------------atributos de la clase-------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idProyecto", type="smallint")
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
     * @ORM\Column(name="asunto", type="string", length=200, nullable=false)
     */
    private $asunto;

    /**
     * @var text
     *
     * @ORM\Column(name="asunto", type="text", nullable=false)
     */
    private $visto;

    /**
     * @var text
     *
     * @ORM\Column(name="considerandos", type="text", nullable=false)
     */
    private $considerandos;

    /**
     * @var string
     *
     * @ORM\Column(name="quienSanciona", type="string", length=130, nullable=false)
     */
    private $quienSanciona;

    /**
     * @var text
     *
     * @ORM\Column(name="articulos", type="text", nullable=false)
     */
    private $articulos;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Perfil", inversedBy="proyectos", fetch="EAGER")
     * @ORM\JoinTable(name="autores_proyectos",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idProyecto", referencedColumnName="idProyecto")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idPerfil", referencedColumnName="idPerfil")
     *   }
     * )
     */
    private $autores;

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
        $this->autores = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param string $tipoProyecto
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
     * @return string
     */
    public function getTipoProyecto()
    {
        return $this->tipoProyecto;
    }

    /**
     * Set asunto
     *
     * @param string $asunto
     *
     * @return Proyecto
     */
    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;

        return $this;
    }

    /**
     * Get asunto
     *
     * @return string
     */
    public function getAsunto()
    {
        return $this->asunto;
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
     * Set considerando
     *
     * @param text $considerando
     *
     * @return Proyecto
     */
    public function setConsiderando($considerando)
    {
        $this->considerando = $considerando;

        return $this;
    }

    /**
     * Get considerando
     *
     * @return text
     */
    public function getConsiderando()
    {
        return $this->considerando;
    }

    /**
     * Set quienSanciona
     *
     * @param string $quienSanciona
     *
     * @return Proyecto
     */
    public function setQuienSanciona($quienSanciona)
    {
        $this->quienSanciona = $quienSanciona;

        return $this;
    }

    /**
     * Get quienSanciona
     *
     * @return string
     */
    public function getQuienSanciona()
    {
        return $this->quienSanciona;
    }

    /**
     * Set articulos
     *
     * @param text $articulos
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
     * @return text
     */
    public function getArticulos()
    {
        return $this->articulos;
    } 

    /**
     * set autores
     *
     * @param \Doctrine\Common\Collections\Collection $autores
     *
     * @return Proyecto
     */
    public function setAutores(\Doctrine\Common\Collections\Collection $autores)
    {
        $this->autores = $autores;

        return $this;
    }

    /**
     * Add autor
     *
     * @param \AppBundle\Entity\Perfil $autor
     *
     * @return Proyecto
     */
    public function addAutor(\AppBundle\Entity\Perfil $autor)
    {
        $this->autores[] = $autor;

        return $this;
    }

    /**
     * Remove autor
     *
     * @param \AppBundle\Entity\Expediente $autor
     *
     * @return Proyecto
     */
    public function removeAutor(\AppBundle\Entity\Perfil $autor)
    {
        $this->autores->removeElement($autor);
    }

    /**
     * Get autores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAutores()
    {
        return $this->autores;
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
     * Get listaAutores
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getListaAutores()
    {
        $autores=$this->autores;
        $listaAutores="";
        foreach ($autores as $autor) {
            $listaAutores.=($listaAutores!=""?"-":"").$autor->getNombreCompleto();
        }
        return $listaAutores;
    }

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

}
