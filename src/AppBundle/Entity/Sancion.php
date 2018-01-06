<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Sancion
 * 
 * @ORM\Table(name="sancion",  indexes={@ORM\Index(name="sancion_speech_idx",columns={"idSpeech"}),
 * 										@ORM\Index(name="sancion_proyectoRevision_idx",columns={"idProyectoRevision"}),
 * 									    @ORM\Index(name="sancion_tipoSancion_idx",columns={"idTiposancion"}),
 * 									    @ORM\Index(name="sancion_dictamen_idx",columns={"idDictamen"}),
 * 										@ORM\Index(name="sancion_pase_idx",columns={"idPase"}),
 * 										@ORM\Index(name="sancion_firmaSecretario_idx",columns={"firmaSecretario"}),
 * 										@ORM\Index(name="sancion_firmaPresidente_idx", columns={"firmaPresidente"})
 * 										})
 * 
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminador", type="string", length=17)
 * @ORM\DiscriminatorMap({"basica" = "AppBundle\Entity\SancionBasica",
 * 						  "articulado" = "AppBundle\Entity\SancionArticulada",
 * 						  "revision" = "AppBundle\Entity\SancionRevisionProyecto"})
 */

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
     * @var \AppBundle\Entity\Speech
     * 
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Speech")
     * @ORM\JoinColumn(name="idSpeech", referencedColumnName="idSpeech")
     */
    private $speech;
    
    /**
     * @var \AppBundle\Entity\Autoridad
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Autoridad")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="firmaPresidente", referencedColumnName="idAutoridad")})
     */
    private $firmaPresidente;
    
    /**
     * @var \AppBundle\Entity\Autoridad
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Autoridad")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="firmaSecretario", referencedColumnName="idAutoridad")})
     */
    private $firmaSecretario;
	
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
    
    //------------------------------------constructor---------------------------------------------
    
    /**
     * Constructor
     *
    public function __construct()
    {
    	$this->firmaPresidente = "";
    	$this->firmaSecretario = "";
    }*/
    
    
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
	 * Get speech
	 * 
	 * @return Speech
	 */
	public function getSpeech() {
		return $this->speech;
	}
	
	/**
	 * Set speech
	 * 
	 * @param \AppBundle\Entity\Speech $speech
	 * @return Sancion
	 */
	public function setSpeech($speech) {
		$this->speech = $speech;
		return $this;
	}
		
	/**
	 * Get firmaPresidente
	 * 
	 * @return \AppBundle\Entity\Autoridad
	 */
	public function getFirmaPresidente() {
		return $this->firmaPresidente;
	}
	
	/**
	 * Set firmaPresidente
	 * 
	 * @param \AppBundle\Entity\Autoridad $firmaPresidente
	 * @return \AppBundle\Entity\Sancion
	 */
	public function setFirmaPresidente($firmaPresidente) {
		$this->firmaPresidente = $firmaPresidente;
		return $this;
	}
	
	/**
	 * Get firmaSecretario
	 * 
	 * @return \AppBundle\Entity\Autoridad
	 */
	public function getFirmaSecretario() {
		return $this->firmaSecretario;
	}
	
	/**
	 * Set firmaSecretario
	 * 
	 * @param \AppBundle\Entity\Autoridad $firmaSecretario
	 * @return \AppBundle\Entity\Sancion
	 */
	public function setFirmaSecretario($firmaSecretario) {
		$this->firmaSecretario = $firmaSecretario;
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
