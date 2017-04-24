<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Popo\Image;

/**
 * Expediente
 *
 * @ORM\Table(name="expediente", indexes={@ORM\Index(name="estadoExpediente_idx", columns={"idEstadoExpediente"}), 
 *                                        @ORM\Index(name="tipoExpediente_idx", columns={"idTipoExpediente"}),
 *                                        @ORM\Index(name="numeroExpediente_idx", columns={"numeroExpediente"})})},
 *            uniqueConstraints={@UniqueConstraint(name="numeroExpediente_idx", columns={"numeroExpediente"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExpedienteRepository")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Expediente
{
    //---------------------------------------transient--------------------------------------------
    /**
    * Campo no persistible
    *
    * @var array
    */
    private $archivos = [];

    /**
    * Campo no persistible
    *
    * @var string
    */
    private $archivoBorrado = '';

    /**
     * Set archivos
     *
     * @param string $archivos
     *
     * @return Expediente
     */
    public function setArchivos($archivos)
    {
        $this->archivos=$archivos;
        return $this;
    }

    /**
     * Set archivoBorrado
     *
     * @param string $archivoBorrado
     *
     * @return Expediente
     */
    public function setArchivoBorrado($archivoBorrado)
    {
        if(is_null($this->id)){
            throw new Exception("setArchivoBorrado :accion no permitida si el expediente no esta persistido");
        }
        else{    
            $this->archivoBorrado = $archivoBorrado;
            return $this;
        }
    }

    //-----------------------------------atributos de la clase------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idExpediente", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *  
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="hashId", type="hash", length=32, nullable=false)
     */
    private $hashId;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroExpediente", type="string", length=50, nullable=false)
     */
    private $numeroExpediente;

    /**
     * @var \AppBundle\Entity\EstadoExpediente
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EstadoExpediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEstadoExpediente", referencedColumnName="idEstadoExpediente")
     * })
     */
    private $estadoExpediente;

    /**
     * @var \AppBundle\Entity\TipoExpediente
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoExpediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTipoExpediente", referencedColumnName="idTipoExpediente")
     * })
     */
    private $tipoExpediente;

    /**
     * @var string
     *
     * @ORM\Column(name="asunto", type="string", length=200, nullable=false)
     */
    private $asunto;

    /**
     * @var string
     *
     * @ORM\Column(name="extracto", type="string", length=500, nullable=false)
     */
    private $extracto;

    /**
     * @var array
     *
     * @ORM\Column(name="listaImagenes", type="object", nullable=true)
     */
    private $listaImagenes =[];

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

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAprobacion", type="datetime", nullable=true)
     */
    private $fechaAprobacion;

    /**
     * @var string
     *
     * @ORM\Column(name="usuarioAprobacion", type="string", length=70, nullable=false)
     */
    private $usuarioAprobacion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Perfil", mappedBy="expedientes")
     */
    private $autores;

    //------------------------------------constructor---------------------------------------------

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->autores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    //-------------------------------setters y getters--------------------------------------------

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /*
     * Set hashId
     *
     * @param string $hashId
     *
     * @return Expediente
     *
    public function setHash($hashId)
    {
        $this->hashId = $hashId;

        return $this;
    }*/

    /**
     * Get hashId
     *
     * @return string
     */
    public function getHashId()
    {
        return $this->hashId;
    }

    /**
     * Set numeroExpediente
     *
     * @param string $numeroExpediente
     *
     * @return Expediente
     */
    public function setNumeroExpediente($numeroExpediente)
    {
        $this->numeroExpediente = $numeroExpediente;

        return $this;
    }

    /**
     * Get numeroExpediente
     *
     * @return string
     */
    public function getNumeroExpediente()
    {
        return $this->numeroExpediente;
    }

    /**
     * Set estadoExpediente
     *
     * @param \AppBundle\Entity\EstadoExpediente $estadoExpediente
     *
     * @return Expediente
     */
    public function setEstadoExpediente(\AppBundle\Entity\EstadoExpediente $estadoExpediente = null)
    {
        $this->estadoExpediente = $estadoExpediente;

        return $this;
    }

    /**
     * Get estadoExpediente
     *
     * @return \AppBundle\Entity\EstadoExpediente
     */
    public function getEstadoExpediente()
    {
        return $this->estadoExpediente;
    }

    /**
     * Set tipoExpediente
     *
     * @param \AppBundle\Entity\TipoExpediente $tipoExpediente
     *
     * @return Expediente
     */
    public function setTipoExpediente(\AppBundle\Entity\TipoExpediente $tipoExpediente = null)
    {
        $this->tipoExpediente = $tipoExpediente;

        return $this;
    }

    /**
     * Get tipoExpediente
     *
     * @return \AppBundle\Entity\TipoExpediente
     */
    public function getTipoExpediente()
    {
        return $this->tipoExpediente;
    }

    /**
     * Set asunto
     *
     * @param string $asunto
     *
     * @return Expediente
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
     * Set extracto
     *
     * @param string $extracto
     *
     * @return Expediente
     */
    public function setExtracto($extracto)
    {
        $this->extracto = $extracto;

        return $this;
    }

    /**
     * Get extracto
     *
     * @return string
     */
    public function getExtracto()
    {
        return $this->extracto;
    }

    /**
     * Set listaImagenes
     *
     * @param array $listaImagenes
     *
     * @return Expediente
     */
    public function setListaImagenes($listaImagenes)
    {
        $this->listaImagenes = $listaImagenes;

        return $this;
    }

    /**
     * Get listaImagenes
     *
     * @return array
     */
    public function getListaImagenes()
    {
        return $this->listaImagenes;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Expediente
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
     * @return Expediente
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
     * @return Expediente
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
     * @return Expediente
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


    /**
     * Set fechaAprobacion
     *
     * @param \DateTime $fechaAprobacion
     *
     * @return Expediente
     */
    public function setFechaAprobacion($fechaAprobacion)
    {
        $this->fechaAprobacion = $fechaAprobacion;

        return $this;
    }

    /**
     * Get fechaAprobacion
     *
     * @return \DateTime
     */
    public function getFechaAprobacion()
    {
        return $this->fechaAprobacion;
    }

    /**
     * Set usuarioAprobacion
     *
     * @param string $usuarioAprobacion
     *
     * @return Expediente
     */
    public function setUsuarioAprobacion($usuarioAprobacion)
    {
        $this->usuarioAprobacion = $usuarioAprobacion;

        return $this;
    }

    /**
     * Get usuarioAprobacion
     *
     * @return string
     */
    public function getUsuarioAprobacion()
    {
        return $this->usuarioAprobacion;
    }

    /**
     * set autores
     *
     * @param \Doctrine\Common\Collections\Collection $autores
     *
     * @return Expediente
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
     * @return Expediente
     */
    public function addAutor(\AppBundle\Entity\Perfil $autor)
    {
        $autor->addExpediente($this);
        return $this;
    }

    /**
     * Remove autor
     *
     * @param \AppBundle\Entity\Perfil $autor
     *
     * @return Expediente
     */
    public function removeAutor(\AppBundle\Entity\Perfil $autor)
    {
        $autor->removeExpediente($this);
        return $this;
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

    //--------------------------------propiedades protegidas---------------------------------------

    /**
     * Get rutaRelativaExpedientes
     *
     * @return string
     *
     */
    public function getRutaRelativaExpedientes()
    {
        return 'upload/expedientes'.DIRECTORY_SEPARATOR;
    }

    /**
     * Get rutaAbsolutaExpedientes
     *
     * @return string
     *
     */
    public function getRutaAbsolutaExpedientes()
    {
        return realpath(__DIR__.'/../../../web').DIRECTORY_SEPARATOR.
               $this->getRutaRelativaExpedientes();
    }

    /**
     * Get nombreCarpeta
     *
     * @return string
     *
     */
    public function getNombreCarpeta()
    {
        return $this->hashId.DIRECTORY_SEPARATOR;
    }

    /**
     * Get rutaInternaExpediente
     *
     * @param  string $nombreArchivo
     *
     * @return string
     *
     */
    public function getRutaInternaExpediente($nombreArchivo)
    {
        return $this->getRutaAbsolutaExpedientes.
               $this->getNombreCarpeta.$nombreArchivo;
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
     * Get resumenSinHtml
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getResumenSinHtml()
    {
        return strip_tags($this->extracto);
    }

    /**
     * Get asuntoSinHtml
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getAsuntoSinHtml()
    {
        return strip_tags($this->asunto);
    }

    /**
     * Get rutasWeb
     *
     * @return array
     *
     * @VirtualProperty
     */
    public function getRutasWebExpediente()
    {
        $rutasWeb=[];
        $listaImagenes=$this->getListaImagenes();
        foreach ($listaImagenes as $imagen) {
            $rutasWeb[]=$this->getRutaRelativaExpedientes().$this->getNombreCarpeta().$imagen->getFileName();
        }
        return $rutasWeb;
    }

    //----------------------------administracion de carga de archivos-------------------------------

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function listarImagenes(){

        if(!is_null($this->id)){

            /* se cambio el numero de expediente */

            if (md5($this->numeroExpediente)!=$this->hashId){

                $nuevaListamagenes=[];

                //Valor hash anterior
                $hashAnterior=$this->hashId;  

                //actualiza valor hash        
                $this->hashId=md5($this->numeroExpediente);

                //actualiza ubicacion archivos
                $imagenes=$this->listaImagenes;
                foreach ($imagenes as $imagen) {
                    $keyAnterior=$imagen->getImageConfig()->getKey();
                    $componentesKey=explode("/",$keyAnterior);
                    //throw new \Exception($this->getNombreCarpeta().'///'.$componentesKey[0].'///'.$componentesKey[1].'///'.$this->hashId);
                    
                    $keyActual=$this->getNombreCarpeta().$componentesKey[1];  
                    $nuevaListaImagenes[]=new Image($imagen->getFileName(),
                                                    $imagen->getImageConfig()->getCaption(),
                                                    $imagen->getImageConfig()->getSize(),
                                                    $imagen->getImageConfig()->getWidth(),
                                                    $keyActual,
                                                    $imagen->getImageConfig()->getType()
                                                    );             
                }


                $this->listaImagenes=$nuevaListaImagenes;
                //renombra carpeta expediente
                $antiguoNombre=$this->getRutaAbsolutaExpedientes().$hashAnterior;
                $nuevoNombre=$this->getRutaAbsolutaExpedientes().$this->hashId;
                rename($antiguoNombre, $nuevoNombre);

            }
        }
        else $this->hashId=md5($this->numeroExpediente);

        //agrega nuevos archivos
        $archivos=$this->archivos;
        foreach ($archivos as $archivo) {
            $this->listaImagenes[]=new Image(md5($archivo->getClientOriginalName()).'.'.$archivo->guessExtension(),
                                                   $archivo->getClientOriginalName(),
                                                   $archivo->getClientSize(),
                                                   '120px',
                                                   $this->getNombreCarpeta().md5($archivo->getClientOriginalName()).'.'.$archivo->guessExtension(),
                                                   ((strtolower($archivo->guessExtension())=='pdf')?'pdf':'image')
                                                   );
        }
    }

    /**
     * @ORM\PreUpdate()
     */
    public function removeSingleImage(){
        $nombreArchivo=$this->archivoBorrado;
        if(!is_null($nombreArchivo)){
            $imagenes=$this->listaImagenes;
            for ($i = 0; $i < count($imagenes); $i++) {
                if ($imagenes[$i]->getFileName()==$nombreArchivo){
                    unset($imagenes[$i]);
                    $this->listaImagenes=$imagenes;
                     $ruta=realpath(__DIR__.'/../../../web').DIRECTORY_SEPARATOR.
                            $this->getRutaRelativaExpedientes().DIRECTORY_SEPARATOR.
                            md5($this->getNumeroExpediente()).DIRECTORY_SEPARATOR.
                            $nombreArchivo;
                    unlink($ruta);
                    break;
                }
            } 
           
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        $archivos=$this->archivos;

        foreach ($archivos as $archivo) {
            $archivo->move($this->getRutaAbsolutaExpedientes().$this->getNombreCarpeta(),
                        md5($archivo->getClientOriginalName()).'.'.$archivo->guessExtension());
        }

    }

    /*  
     * @ORM\PostRemove()
     *
    public function removeUpload()
    {
        foreach ($listaNombreArchivos as $nombreArchivo) {
            $archivo=$this->getRutaInternaExpediente($nombreArchivo);
            unlink($archivo);
        }
    }*/
}
