<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Autoridad
 *
 * @ORM\Table(name="autoridad", indexes={@ORM\Index(name="autoridad_tipoAutoridad_idx", columns={"idTipoAutoridad"}),
 * 										 @ORM\Index(name="autoridad_perfil_idx", columns={"idPerfil"})
 * 										}
 * 			 )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AutoridadRepository")
 */
class Autoridad
{
    //--------------------------------------atributos de la clase---------------------------------
    
    /**
     * @var integer
     *
     * @ORM\Column(name="idAutoridad", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var \AppBundle\Entity\Perfil
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Perfil")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="idPerfil", referencedColumnName="idPerfil",
     * 									 nullable=false)
     * 					})
     */
    private $perfil;

    /**
     * @var \AppBundle\Entity\TipoAutoridad
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoAutoridad")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="idTipoAutoridad", referencedColumnName="idTipoAutoridad",
     * 									 nullable=false)
     * 				   })
     */
    private $tipoAutoridad;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="activo", type="boolean", nullable=false)
     */
    private $activo;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="fechaAlta", type="datetime", nullable=false)
     */
    private $fechaAlta;
    
    /**
     * @var string
     * @ORM\Column(name="usuarioAlta", type="string", length=70, nullable=false)
     */
    private $usuarioAlta;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->activo=true;
    }

    //------------------------------------setters y getters---------------------------------------

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
     * Get Perfil
     * 
     * @return \AppBundle\Entity\Perfil
     */
	public function getPerfil() {
		return $this->perfil;
	}
	
	/**
	 * Set Perfil
	 * 
	 * @param \AppBundle\Entity\Perfil $perfil
	 * @return Autoridad
	 */
	public function setPerfil($perfil) {
		$this->perfil = $perfil;
		return $this;
	}
	
	/**
	 * Get tipoAutoridad
	 * 
	 * @return \AppBundle\Entity\TipoAutoridad
	 */
	public function getTipoAutoridad() {
		return $this->tipoAutoridad;
	}
	
	/**
	 * Set tipoAutoridad
	 * 
	 * @param \AppBundle\Entity\TipoAutoridad $tipoAutoridad
	 * @return Autoridad
	 */
	public function setTipoAutoridad($tipoAutoridad) {
		$this->tipoAutoridad = $tipoAutoridad;
		return $this;
	}
	
	/**
	 * Get activo
	 * 
	 * @return boolean
	 */
	public function getActivo() {
		return $this->activo;
	}
	
	/**
	 * Set activo
	 * 
	 * @param boolean $activo
	 * @return \AppBundle\Entity\Autoridad
	 */
	public function setActivo($activo) {
		$this->activo = $activo;
		return $this;
	}
	
	/**
	 * Get fechaAlta
	 * 
	 * @return DateTime
	 */
	public function getFechaAlta() {
		return $this->fechaAlta;
	}
	
	/**
	 * Set fechaAlta
	 * 
	 * @param \DateTime $fechaAlta
	 * @return \AppBundle\Entity\Autoridad
	 */
	public function setFechaAlta(\DateTime $fechaAlta) {
		$this->fechaAlta = $fechaAlta;
		return $this;
	}
	
	/**
	 * Get usuarioAlta
	 * 
	 * @return string
	 */
	public function getUsuarioAlta() {
		return $this->usuarioAlta;
	}
	
	/**
	 * Set usuarioAlta
	 * 
	 * @param String $usuarioAlta
	 * @return \AppBundle\Entity\Autoridad
	 */
	public function setUsuarioAlta($usuarioAlta) {
		$this->usuarioAlta = $usuarioAlta;
		return $this;
	}
		
    
}
