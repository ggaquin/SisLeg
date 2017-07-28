<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * DemandanteParticular
 *
 * @ORM\Table(name="demandantePerticular")
 * @ORM\Entity()
 */
class DemandanteParticular
{
    //-----------------------------------------atributos de la clase-------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idDemandanteParticular", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @ORM\Column(name="apedocumentollidos", type="string", length=8)
     */
    private $documento;
 
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
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return DemandanteParticular
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
     * @return DemandanteParticular
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
     * Set documento
     *
     * @param string $documento
     *
     * @return DemandanteParticular
     */
    public function setDocumento($documento)
    {
    	$this->documento = $documento;
    	
    	return $this;
    }
    
    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
    	return $this->documento;
    }
    
    //------------------------------Propiedades virtuales-----------------------------------------
    
    
    /**
     * Get descripcion
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getDescripcion()
    {   $descripcion = "Documento: " .$this->getDocumento();
    	$descripcion .=" - Nombre :" .$this->getApellidos() .", ".$this->getNombres();
    	return $descripcion;
    }
}
