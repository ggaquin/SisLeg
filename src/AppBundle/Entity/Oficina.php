<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oficina
 *
 * @ORM\Table(name="oficina",indexes={@ORM\Index(name="oficina_tipoOficina_idx", columns={"idTipoOficina"})})
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
	 * @var \AppBundle\Entity\TipoOficina
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoOficina")
	 * @ORM\JoinColumns({@ORM\JoinColumn(name="idTipoOficina", referencedColumnName="idTipoOficina")})
	 */
	private $tipoOficina;
	
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
	
	/**
	 * Get tipoOficina
	 *
	 * @return \AppBundle\Entity\TipoOficina
	 */
	public function getTipoOficina() {
		return $this->tipoOficina;
	}
	
	/**
	 * Set tipoOficina
	 *
	 * @param \AppBundle\Entity\TipoOficina $tipoOficina
	 *
	 * @return Oficina
	 */
	public function setTipoOficina(\AppBundle\Entity\TipoOficina $tipoOficina) {
		$this->oficina = $tipoOficina	;
		return $this;
	}
	
}