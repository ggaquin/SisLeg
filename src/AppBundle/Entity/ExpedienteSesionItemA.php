<?php

namespace AppBundle\Entity;

use AppBundle\Entity\ExpedienteSesion;

class ExpedienteSesionItemA extends ExpedienteSesion {
	
	
	public function getDatosAImprimir() {
		$elementos=[];
		$elementos[]='<p>A) '.$this->getOrdenSesion().'.- <strong>'.$this->getExpediente()->getNumeroCompleto().'</strong></p>';
		$elementos[]=$this->getExpediente()->getCaratula();
		return $elementos;
		
	}
}