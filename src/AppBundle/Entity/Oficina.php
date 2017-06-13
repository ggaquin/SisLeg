<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oficina
 *
 * @ORM\Table(name="oficina")
 * 
 * @ORM\Entity
 */

class Oficina {
	
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idOficina", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="$oficina", type="String", length=100, nullable=false)
	 */
	private $oficina;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="codigo", type="String", length=15, nullable=false)
	 */
	private $codigo;
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * get oficina
	 *
	 * @return string
	 */
	public function getOficina() {
		return $this->oficina;
	}
	
	/**
	 * Set oficina
	 *
	 * @param string $oficina
	 *
	 * @return Oficina
	 */
	public function setOficina($oficina) {
		$this->oficina = $oficina;
		return $this;
	}
	
	/**
	 * get codigo
	 *
	 * @return string
	 */
	public function getCodigo() {
		return $this->codigo;
	}
	
	/**
	 * Set codigo
	 *
	 * @param string $codigo
	 *
	 * @return Oficina
	 */
	public function setCodigo($codigo) {
		$this->codigo = $codigo;
		return $this;
	}
	
}