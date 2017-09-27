<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
/**
 * Perfil
 *
 * @ORM\Table(name="perfil",indexes={@ORM\Index(name="perfil_bloque_idx", columns={"idBloque"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PerfilRepository")
 * @ORM\HasLifecycleCallbacks 
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminador", type="string", length=20)
 * @ORM\DiscriminatorMap({"basico" = "AppBundle\Entity\Perfil", 
 *                        "legislador" = "AppBundle\Entity\PerfilLegislador", 
 *                        "publico" = "AppBundle\Entity\PerfilPublico"})
 */
class Perfil
{
    //---------------------------------------transient--------------------------------------------

    /**
    * Campo no persistible
    *
    * @var \Symfony\Component\HttpFoundation\File\UploadedFile
    */
    private $archivo=null;

    /**
    * Campo no persistible
    *
    * @var string
    */
    private $prefijo;

    /**
    * Campo no persistible
    *
    * @var boolean
    */
    private $borrarImagen=false;

    /**
     * Set archivo
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $archivo
     *
     * @return Perfil
     */
    public function setArchivo($archivo)
    {
        $this->archivo=$archivo;
        return $this;
    }

    /**
     * Set borrarImagen
     * @return Perfil
     */
    public function setBorrarImagen()
    {
        $this->borrarImagen=true;
        return $this;
    }

    /**
     * Set prefijo
     * @param string $prefijo
     * @return Perfil
     */
    public function setPrefijo($prefijo)
    {
        $this->$prefijo=$prefijo;
        return $this;
    }
    
    //-------------------------------atributos de la clase----------------------------------------
    /**
     * @var integer
     *
     * @ORM\Column(name="idPerfil", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=100, nullable=true)
     */
    private $imagen=null;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=70, nullable=false)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=70, nullable=false)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=70, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="correoElectronico", type="string", length=70, nullable=true)
     */
    private $correoElectronico;

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
     * @ORM\Column(name="usuarioModificacion", type="string", length=70, nullable=true)
     */
    private $usuarioModificacion;

    //-----------------------------------constructor------------------------------------------------

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->proyectos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    //----------------------------------getters y setters-------------------------------------------

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
     * Set imagen
     *
     * @param string $imagen
     *
     * @return Perfil
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Perfil
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     *
     * @return Perfil
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

     /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Perfil
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

     /**
     * Get correoElectronico
     *
     * @return string
     */
    public function getCorreoElectronico()
    {
        return $this->correoElectronico;
    }

     /**
     * Set correoElectronico
     *
     * @param string $correoElectronico
     *
     * @return Perfil
     */
    public function setCorreoElectronico($correoElectronico)
    {
        $this->correoElectronico = $correoElectronico;

        return $this;
    }

    /**
     * Add proyect
     *
     * @param \AppBundle\Entity\Proyecto $proyecto
     *
     * @return Perfil
     */
    public function addProyecto(\AppBundle\Entity\Proyecto $proyecto)
    {
        $proyecto->addAutor($this);
        $this->autores[]=$proyecto;
        return $this;
    }

    /**
     * Remove proyecto
     *
     * @param \AppBundle\Entity\Proyecto $proyecto
     *
     * @return Perfil
     */
    public function removeExpediente(\AppBundle\Entity\Expediente $proyecto)
    {
        $this->proyectos->removeElement($proyecto);
        return $this;
    }

    /**
     * Get proyectos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExpedientes()
    {
        return $this->proyectos;
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

    //--------------------------------propiedades protegidas---------------------------------------

    /**
     * Get rutaRelativaImagen
     *
     * @return string
     *
     */
    protected function getRutaRelativaImagen()
    {
        return 'upload/perfiles'.DIRECTORY_SEPARATOR;
    }

    /**
     * Get rutaAbsolutaImagen
     *
     * @return string
     *
     */
    protected function getRutaAbsolutaImagen()
    {
        return realpath(__DIR__.'/../../../web').DIRECTORY_SEPARATOR.
               $this->getRutaRelativaImagen();
    }

    /**
     * Get rutaInternaImagen
     *
     * @param  string $nombreImagen
     *
     * @return string
     *
     */
    public function getRutaInternaImagen($nombreImagen)
    {
        return $this->getRutaAbsolutaImagen().$nombreImagen;
    }

    //-------------------------------propiedades virtuales-----------------------------------------

    /**
     * Get NombreCompleto
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getNombreCompleto()
    {
        return $this->apellidos.', '.$this->nombres;
    }

    /**
     * Get RutaWebImagen
     *
     * @return array
     *
     * @VirtualProperty
     */
    public function getRutaWebImagen(){

        return ((is_null($this->imagen))?null:$this->getRutaRelativaImagen().
                                              $this->imagen);
    }


    /**
     * Get tipoPerfil
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getTipoPerfil()
    {
        return "administrativo";
    }

    //----------------------------administracion de carga de archivos-------------------------------

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function almacenarImagen(){

        if (!is_null($this->archivo)){
            if(!is_null($this->imagen))
                unlink($this->getRutaInternaImagen($this->imagen));
            $this->prefijo=md5($this->prefijo.uniqid());
            $this->imagen=md5($this->prefijo).'_'.md5($this->archivo->getClientOriginalName()).'.'.
                              $this->archivo->guessExtension();  
        }   
    }

    /**
     * @ORM\PreUpdate()
     */
    public function removeImage(){
        if($this->borrarImagen==true && !is_null($this->imagen)){
            $ruta=realpath(__DIR__.'/../../../web').DIRECTORY_SEPARATOR.
                  $this->getRutaRelativaImagen().DIRECTORY_SEPARATOR.
                  $this->imagen;
            unlink($ruta);
            $this->imagen=null;
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (!is_null($this->archivo)){
            $this->archivo->move($this->getRutaAbsolutaImagen(),
                                 md5($this->prefijo).'_'.md5($this->archivo->getClientOriginalName()).'.'.
                                 $this->archivo->guessExtension());
        }
    }

}
