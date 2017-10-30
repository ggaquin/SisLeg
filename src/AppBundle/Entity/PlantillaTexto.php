<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * PlantillaTexto
 * 
 * @ORM\Table(name="plantillaTexto", indexes={@ORM\Index(name="plantillaTexto_tipoPlantillaTexto_idx",columns={"idTipoPlantillaTexto"})
 * 										})
 * 			  )
 * @ORM\Entity()
 *
 */
class PlantillaTexto {
	
	//-----------------------------------------atributos de la clase-------------------------------
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idPlantillaTexto", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="plantillaTexto", type="string", length=1000)
	 */
	private $plantillaTexto;
	
	/**
	 * @var \AppBundle\Entity\TipoPlantillaTexto
	 * 
	 * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\TipoPlantillaTexto")
	 * @ORM\JoinColumn(name="idTipoPlantillaTexto", referencedColumnName="idTipoPlantillaTexto")
	 */
	private $tipoPlantillaTexto;
	
	//-------------------------------------setters y getters--------------------------------------
	
	/**
	 * Get id
	 * 
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Get plantillaTexto
	 * 
	 * @return string
	 */
	public function getPlantillaTexto() {
		return $this->plantillaTexto;
	}
	
	/**
	 * Set plantillaTexto
	 * 
	 * @param string $plantillaTexto
	 * @return PlantillaTexto
	 */
	public function setPlantillaTexto($plantillaTexto) {
		$this->plantillaTexto = $plantillaTexto;
		return $this;
	}
	
	/**
	 * Get tipoPlantillaTexto
	 * 
	 * @return \AppBundle\Entity\TipoPlantillaTexto
	 */
	public function getTipoPlantillaTexto() {
		return $this->tipoPlantillaTexto;
	}
	
	/**
	 * Set tipoPlantillaTexto
	 * 
	 * @param \AppBundle\Entity\TipoPlantillaTexto $tipoPlantillaTexto
	 * @return PlantillaTexto
	 */
	public function setTipoPlantillaTexto($tipoPlantillaTexto) {
		$this->tipoPlantillaTexto = $tipoPlantillaTexto;
		return $this;
	}
	
}