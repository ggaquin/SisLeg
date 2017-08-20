<?php

namespace AppBundle\Entity;

use AppBundle\Entity\ExpedienteSesion;

class ExpedienteSesionItemC extends ExpedienteSesion {
	
	public function getDatosAImprimir() {
		
		$elementos=[];
		$elementos[]='<p>C) '.$this->getOrdenSesion().'.- <strong>'.$this->getExpediente()->getNumeroCompleto().'</strong></p>';
		$elementos[]=$this->getExpediente()->getCaratula();
		$elementos[]=$this->getExpediente()->getProyecto()->getVisto();
		$elementos[]=$this->getExpediente()->getProyecto()->getConsiderandos();
		$articulos=$this->getExpediente()->getProyecto()->getArticulos();
		$pgph_style='<p style="text-align: justify;margin-top: 0">&nbsp;&nbsp;&nbsp;&nbsp;';
		$htmlArticulos='';
		foreach ($articulos as $articulo) {
			$textoArticulo=substr($articulo['texto'], 3,strlen($articulo['texto'])+3);
			$textoArticulo=str_replace('<p>', $pgph_style, $textoArticulo);
			$htmlArticulos.='<p><strong><u>Artículo '.$articulo['numero'].'°</u>.- </strong>';
			$htmlArticulos.=$textoArticulo;
			
			if(count($articulo['incisos'])>0){
				$htmlArticulos.='<ul style="list-style-type: none;">';
				foreach ($articulo['incisos'] as $inciso) {
					$htmlArticulos.='<li>'.$inciso['orden'].' '.strip_tags($inciso['texto'],'<br>').'</li>';
				}
				$htmlArticulos.='</ul>';
			}
		} 
		$elementos[]=$htmlArticulos;
		
		return $elementos;	
	}
}