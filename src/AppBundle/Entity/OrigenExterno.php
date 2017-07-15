<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrigenExterno
 *
 * @ORM\Table(name="origenExterno", indexes={@ORM\Index(name="origenExterno_oficina_idx", columns={"idOficina"})})
 * @ORM\Entity
 */
class OrigenExterno
{
    //-----------------------------------------atributos de la clase-------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idOrigenExterno", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="numeracionOrigen", type="json_array", nullable=false)
     */
    private $numeracionOrigen;
    
    /**
     * @var \AppBundle\Entity\Oficina
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Oficina")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idOficina", referencedColumnName="idOficina")
     * })
     */
    private $oficina;

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
     * Set numeracionOrigen
     *
     * @param array $numeracionOrigen
     *
     * @return OrigenExterno
     */
    public function setNumeracionOrigen($numeracionOrigen)
    {
    	$this->numeracionOrigen = $numeracionOrigen;
    	
    	return $this;
    }
    
    /**
     * Get numeracionOrigen
     *
     * @return array
     */
    public function getNumeracionOrigen()
    {
    	return $this->numeracionOrigen;
    } 
    
    /**
     * Set oficina
     *
     * @param \AppBundle\Entity\Oficina $oficina
     *
     * @return OrigenExterno
     */
    public function setOficina(\AppBundle\Entity\Oficina $oficina = null)
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
    
}
