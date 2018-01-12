<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoExpedienteSesion
 *
 * @ORM\Table(name="tipoExpedienteSesion",indexes={@ORM\Index(name="letra_idx",columns={"letra"})})
 * @ORM\Entity
 */
class TipoExpedienteSesion
{
    //--------------------------------------atributos de la clase---------------------------------
    
    /**
     * @var integer
     *
     * @ORM\Column(name="idTipoExpedienteSesion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoExpedienteSesion", type="string", length=70, nullable=false)
     */
    private $tipoExpedienteSesion;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="letra" ,type="string", length=2, nullable=false)
     */
    private $letra;

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
     * Get tipoExpedienteSesion
     * @return string
     */
	public function getTipoExpedienteSesion() {
		return $this->tipoExpedienteSesion;
	}
	
	/**
	 * Set tipoExpedienteSesion
	 * 
	 * @param string $tipoExpedienteSesion
	 * 
	 * @return TipoExpedienteSesion
	 */
	public function setTipoExpedienteSesion($tipoExpedienteSesion) {
		$this->tipoExpedienteSesion = $tipoExpedienteSesion;
		return $this;
	}
	
	/**
	 * Get letra
	 * 
	 * @return string
	 */
	public function getLetra() {
		return $this->letra;
	}
	
	/**
	 * Set letra
	 * 
	 * @param string $letra
	 * 
	 * @return TipoExpedienteSesion
	 */
	public function setLetra($letra) {
		$this->letra = $letra;
		return $this;
	}
	
}
