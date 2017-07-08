<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bloque
 *
 * @ORM\Table(name="bloque")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BloqueRepository")
 */
class Bloque
{
    //-----------------------------------------atributos de la clase-------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idBloque", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="bloque", type="string", length=100, nullable=false)
     */
    private $bloque;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PerfilLegislador", mappedBy="bloque")
     */
    private $concejales;
    
    //------------------------------------constructor---------------------------------------------
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->concejales = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set bloque
     *
     * @param string $bloque
     *
     * @return Bloque
     */
    public function setBloque($bloque)
    {
        $this->bloque = $bloque;

        return $this;
    }

    /**
     * Get bloque
     *
     * @return string
     */
    public function getBloque()
    {
        return $this->bloque;
    }
    
    /**
     * Add concejal
     *
     * @param \AppBundle\Entity\PerfilLegislador $concejal
     *
     * @return Bloque
     */
    public function addConcejal(\AppBundle\Entity\PerfilLegislador $concejal)
    {
    	$this->concejales[] = $concejal;
    	
    	return $this;
    }
    
    /**
     * Remove concejal
     *
     * @param \AppBundle\Entity\PerfilLegislador $concejal
     */
    public function removeConcejal(\AppBundle\Entity\PerfilLegislador $concejal)
    {
    	$this->concejales->removeElement($concejal);
    }
    
    /**
	 * Get concejales
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getConcejales()
	{
		return $this->concejales;
	}
    
}
