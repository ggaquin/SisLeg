<?php

namespace AppBundle\Entity;

use AppBundle\Entity\ExpedienteSesion;
use Doctrine\ORM\Mapping as ORM;

class ExpedienteSesionItemB extends ExpedienteSesion {
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="comisiones", type="integer")
	 */
	private $comisiones;
	
	/**
	 * Get comisiones
	 * 
	 * @return string
	 */
	public function getComisiones() {
		return $this->comisiones;
	}
	
	/**
	 * Set Comisiones
	 * @param string $comisiones
	 * @return ExpedienteSesionItemB
	 */
	public function setComisiones($comisiones) {
		$this->comisiones = $comisiones;
		return $this;
	}
	
	public function getDatosAImprimir() {
		$elementos=[];
		$elementos[]='<p>B) '.$this->getOrdenSesion().'.- <strong>'.$this->getExpediente()->getNumeroCompleto().'</strong></p>';
		$elementos[]=$this->getExpediente()->getCaratula();
		$elementos[]=$this->getComisiones();
		return $elementos;
	}
}