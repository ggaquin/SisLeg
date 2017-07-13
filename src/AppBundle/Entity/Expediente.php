<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use \DateTime;
use AppBundle\Popo\Image;

/**
 * Expediente
 *
 * @ORM\Table(name="expediente", indexes={@ORM\Index(name="expediente_estadoExpediente_idx", columns={"idEstadoExpediente"}), 
 *                                        @ORM\Index(name="expediente_tipoExpediente_idx", columns={"idTipoExpediente"}),
 *                                        @ORM\Index(name="expediente_oficina_idx", columns={"idOficina"})
 *                                       },
 *            uniqueConstraints={@ORM\UniqueConstraint(name="numeroExpediente_idx", columns={"numeroExpediente"})})
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
    private $archivoBorrado;

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
            throw new \Exception("setArchivoBorrado :accion no permitida si el expediente no esta persistido");
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
     * @ORM\Column(name="caratula", type="string", length=500, nullable=false)
     */
    private $caratula;

    /**
     * @var string
     *
     * @ORM\Column(name="folios", type="string", length=4, nullable=false)
     */
    private $folios;
    
    /**
     * @var \AppBundle\Entity\Oficina
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Oficina")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idOficina", referencedColumnName="idOficina")
     * })
     */
    private $oficinaActual;

     /**
     * @var string
     *
     * @ORM\Column(name="apellidosSiParticular", type="string", length=80, nullable=true)
     */
    private $apellidosSiParticular;

    /**
     * @var string
     *
     * @ORM\Column(name="nombresSiParticular", type="string", length=80, nullable=true)
     */
    private $nombresSiParticular;

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
     *  @var \AppBundle\Entity\Proyecto $proyecto
     * 
     *  @ORM\OneToOne(targetEntity="\AppBundle\Entity\Proyecto", mappedBy="expediente")
     */
    private $proyecto;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Movimiento", mappedBy="expediente", 
     * 				  cascade={"persist", "remove"},orphanRemoval=true)
     */
    private $movimientos;
   

    //------------------------------------constructor---------------------------------------------

    /**
     * Constructor
     */
    public function __construct()
    {
       $this->fechaCreacion=new \DateTime("now");
       $this->archivoBorrado="";
       $this->movimientos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set caratula
     *
     * @param string $caratula
     *
     * @return Expediente
     */
    public function setCaratula($caratula)
    {
        $this->caratula = $caratula;

        return $this;
    }

    /**
     * Get caratula
     *
     * @return string
     */
    public function getCaratula()
    {
        return $this->caratula;
    }

    /**
     * Set folios
     *
     * @param string $folios
     *
     * @return Expediente
     */
    public function setFolios($folios)
    {
        $this->folios = $folios;

        return $this;
    }

    /**
     * Get folios
     *
     * @return string
     */
    public function getFolios()
    {
        return $this->folios;
    }
    
    /**
     * Get oficinaActual
     *
     * @return \AppBundle\Entity\Oficina
     */
    public function getOficinaActual()
    {
    	return $this->oficinaActual;
    }
    
    /**
     * Set oficinaActual
     *
     * @param \AppBundle\Entity\Oficina $oficinaActual
     *
     * @return Expediente
     */
    public function setOficinaActual(\AppBundle\Entity\Oficina $oficinaActual=null)
    {
    	$this->oficinaActual= $oficinaActual;
    	
    	return $this;
    }

    /**
     * Set apellidosSiParticular
     *
     * @param string $apellidos
     *
     * @return Expediente
     */
    public function setApellidosSiParticular($apellidos)
    {
        $this->apellidosSiParticular = $apellidos;

        return $this;
    }

    /**
     * Get apellidosSiParticular
     *
     * @return string
     */
    public function getApellidosSiParticular()
    {
        return $this->apellidosSiParticular;
    }

    /**
     * Set nombresSiParticular
     *
     * @param string $nombres
     *
     * @return Expediente
     */
    public function setNombresSiParticular($nombres)
    {
        $this->nombresSiParticular = $nombres;

        return $this;
    }

    /**
     * Get nombresSiParticular
     *
     * @return string
     */
    public function geNombresSiParticular()
    {
        return $this->nombresSiParticular;
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
     * Set proyecto
     *
     * @param \AppBundle\Entity\Proyecto $proyecto
     *
     * @return Expediente
     */
    public function setProyecto(\AppBundle\Entity\Proyecto $proyecto = null)
    {
        $proyecto->setExpediente($this);
        $this->proyecto=$proyecto;

        return $this;
    }

    /**
     * Get proyecto
     *
     * @return \AppBundle\Entity\Proyecto
     */
    public function getProyecto()
    {
        return $this->proyecto;
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
     * set movimientos
     *
     * @param array $nuevosMovimientos
     *
     * @return Expediente
     */
    public function setMovimientos($nuevosMovimientos)
    {
    	$collection= new \Doctrine\Common\Collections\ArrayCollection();
    	foreach ($nuevosMovimientos as $movimiento) {
    		$movimiento->setExpediente($this);
    		$collection[]=$movimiento;
    	}
    	$this->movimientos = $collection;
    	
    	return $this;
    }
    
    /**
     * Add movimiento
     *
     * @param \AppBundle\Entity\Movimiento $movimiento
     *
     * @return Expediente
     */
    public function addMovimiento(\AppBundle\Entity\Movimiento $movimiento)
    {
    	$movimiento->setExpediente($this);
    	$this->movimientos[] = $movimiento;
    	
    	return $this;
    }
    
    /**
     * Remove movimiento
     *
     * @param \AppBundle\Entity\Movimiento $movimiento
     *
     * @return Expediente
     */
    public function removeMovimiento(\AppBundle\Entity\Movimiento $movimiento)
    {
    	$this->movimientos->removeElement($movimiento);
    	return $this;
    }
    
    /**
     * Get movimiento
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovimientos()
    {
    	return $this->movimientos;
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
     * Get numeroCompleto
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getNumeroCompleto()
    {   $año = $this->fechaCreacion->format("Y");
        return $this->numeroExpediente.'-'.($this->tipoExpediente->getLetra()).'-'.substr($año,2,2);
    }

     /**
     * Get ejercicio
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getEjercicio()
    {   $año=$this->fechaCreacion->format("Y");
        return substr($año,2,2);
    }

    /**
     * Get caratulaSinHtml
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getCaratulaSinHtml()
    {	
    	    	
    	$caratula=preg_replace("/(<p><br><\/p>)\\1+/", "$1", $this->getCaratula());
    	$patrones = array();
    	$patrones[0] = '/<p><br><\/p>/';
    	$patrones[1] = '/<\/p>/';
    	$patrones[2] = '/<\/li>/';
    	$patrones[3] = '/<\/ul>/';
    	$patrones[4] = '/<li>/';
    	$sustituciones = array();
    	$sustituciones[0] = '';
    	$sustituciones[1] = chr(10);
    	$sustituciones[2] = chr(10);
    	$sustituciones[3] = chr(10);
    	$sustituciones[3] = '--*';
    	
    	$caratula=preg_replace($patrones, $sustituciones, $caratula);
    	$caratula=strip_tags($caratula);
    	$retorno='';
    	$parrafos=explode(chr(10), $caratula);
    	foreach ($parrafos as $parrafo){
    		$inicio=0;
    		$caracteres=strlen($parrafo);
    		$tabulacion=((substr($parrafo, 0, 1)=='-')?'	':'');
    		$parrafo=((substr($parrafo, 0, 1)=='-')?'':'  ').$parrafo;
    		while ($inicio<$caracteres){
    			$retorno.=$tabulacion.(($caracteres-$inicio>100)
				    					?substr($caratula, $inicio, (($inicio==0 && $tabulacion=='')?96:100))
    									:substr($caratula, $inicio, $caracteres-$inicio)).chr(10);
    			$inicio+=100;
    		}
    	}
        return $retorno;
    }
    
    /**
     * Get caratulaSinHtml	
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getCaratulaMuestra()
    {
    	
    	$retorno='';
    	//elimina los retornos de carro repetidos
    	$caratula=preg_replace("/(<p><br><\/p>)\\1+/", "$1", $this->getCaratula());
    	$largoTexto=strlen($caratula);
    	$finPrimerParrafo=strpos($caratula,'</p>');
    	$finSegundoParrafo=(($finPrimerParrafo!=false && strlen($caratula)>$finPrimerParrafo)
    							?strpos(substr($caratula, $finPrimerParrafo+4,strlen($caratula)),'</p>')
    							:false);
    	//descarta el segundo parrafo sis es un retorno de linea
    	$finSegundoParrafo=((substr($caratula, $finPrimerParrafo+$finSegundoParrafo,4)=='<br>')
    			?$finPrimerParrafo:$finPrimerParrafo+4+$finSegundoParrafo);
    	//si largo de texto es menor que 154 characteres
    	if($largoTexto<=154){
    		//el limite es o el largo de a cadena o el fin del segundo parrafo (si existe)
    		$limite=(($finSegundoParrafo!=false && $finSegundoParrafo<$largoTexto)
    					?$finSegundoParrafo:$largoTexto);
    		$retorno=substr($caratula, 0,($limite-4)).'...</p>';	
    	}
    	else //el largo es mayor de 154 caracteres
    	{	
    		$posicionEnTramo=strpos(substr($caratula, 145,8),'</p>');
    		
    		//no hay parrafos en los alrededores del área de corte
	    	if ($posicionEnTramo==false){
	    		$caratula=substr($caratula,0,150);
	    		
	    		//ultimo cierre de parrafo en los primeros 150 caracteres
	    		$posicionCorte=strpos($caratula, '</p>');
	    		
	    		//no hay parrafos entre los primero 150 caracteres
		    	if ($posicionCorte==false){
		    		$retorno=$caratula.'...</p>';
		    	}
		    	elseif ($posicionCorte<143){ //hay un cierre de parrafo entre los ultimos 143 caracteres
		    		$limite=(($finSegundoParrafo!=false && $finSegundoParrafo<strlen($caratula))
		    				?$finSegundoParrafo:strlen($caratula));
					
		    		$retorno=substr($caratula, 0, $limite).'...</p>';
		    	}
		    	else {//hay un cierres de parrafo por encima los primero 143 caracteres
		    		$limite=(($finSegundoParrafo!=false && $finSegundoParrafo<$posicionCorte)
		    				?$finSegundoParrafo:$posicionCorte);
		    		
		    		$retorno=substr($caratula, 0, $limite).'...</p>';
		    	}
	    	}
	    	else{
	    		$limite=(($finSegundoParrafo!=false && $finSegundoParrafo<$posicionEnTramo+145)
	    				?$finSegundoParrafo:$posicionEnTramo+145);
	    		
	    		$retorno=substr($caratula, 0,$limite).'...</p>';
	    	}
	    	
    	}
    	return  $retorno;
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

    /**
     * Get listaAutores
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getListaAutores()
    {
        return ((!is_null($this->proyecto))
                ?$this->getProyecto()->getListaConcejales()
                :'---');
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
        return $this->getFechaCreacion()->format('d/m/Y');
    }

    /**
     * Get fechaModificacionFormateada
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getFechaModificacionFormateada()
    {
        return (!is_null($this->fechaModificacion)?$this->fechaModificacion->format('d/m/Y'):'');
    }



    //----------------------------administracion de carga de archivos-------------------------------

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function listarImagenes(){
	
        $imagenes=$this->listaImagenes;
        
        if(is_null($this->id))
        	$this->hashId=md5($this->usuarioCreacion.uniqid());

        //agrega nuevos setArchivos
        $archivos=$this->archivos;
        
        foreach ($archivos as $archivo) {

            $existe=false;

            foreach ($imagenes as $imagen) {
                if ($imagen->getImageConfig()->getCaption()==$archivo->getClientOriginalName()){
                    $existe=true;
                    break;
                }
            }
            if($existe==false)
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
        $nuevaListaImagenes=[];
        if($nombreArchivo!=""){
            $imagenes=$this->listaImagenes;
 
            for ($i = 0; $i < count($imagenes); $i++) {
                
                if ($imagenes[$i]->getFileName()==$nombreArchivo){
                     $ruta=realpath(__DIR__.'/../../../web').DIRECTORY_SEPARATOR.
                            $this->getRutaRelativaExpedientes().//DIRECTORY_SEPARATOR.
                            $this->getNombreCarpeta().//DIRECTORY_SEPARATOR.
                            $nombreArchivo;

                    unlink($ruta);
                }
                else $nuevaListaImagenes[]=$imagenes[$i];
            }
            
            $this->listaImagenes=$nuevaListaImagenes;
            
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
