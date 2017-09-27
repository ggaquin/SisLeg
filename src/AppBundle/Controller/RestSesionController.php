<?php

namespace AppBundle\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
;

// use twig\twig;


use AppBundle\AppBundle;
use AppBundle\Entity\Sesion;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use AppBundle\Entity\ExpedienteSesion;

/**
 * @Route("/api/sesion")
 *
 */
class RestSesionController extends FOSRestController{
   
       
    /**
     * @Rest\Get("/getByCriteria/{criterio}")
     */
    public function traerSesionesPorCriterioAction(Request $request){
    	
    	$criterio=$request->get('criterio');
    	
    	$sesionReposiory=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesiones=[];
    	if ($criterio=="actuales"){
    		$fecha=new \DateTime('now');
    		$año = substr($fecha->format("Y"),2,2);    		
    		$sesiones=$sesionReposiory->findBy(array('periodo' => $año));
    	}
    	else
    		$sesiones=$sesionReposiory->findAll();
    	
    	$resutado=[];
    	foreach ($sesiones as $sesion){
    		$registro=array('id'=>$sesion->getId(), 
    						'tiene_orden_del_dia'=>$sesion->getTieneOrdenDelDia(),
    						'tipo_sesion'=>$sesion->getTipoSesion()->getTipoSesion(),
    						'descripcion'=>$sesion->getDescripcion(),
    						'fecha_formateada'=>$sesion->getFechaFormateada(),
    						'año'=>$sesion->getPeriodo(),
    						'cantidad_expedientes'=>$sesion->getCantidadExpedientes(),
    						'tiene_edicion_bloqueada'=>$sesion->getTieneEdicionBloqueada()
    						);
    		$resutado[]=$registro;
    			
    	}
    		
    	return $this->view($resutado,200);
    }
    
    /**
     * @Rest\Get("/getOne/{id}")
     */
    public function traerSesionPorId(Request $request){
    	
    	$idSesion=$request->get('id');
    	
    	$sesionReposiory=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesion=$sesionReposiory->find($idSesion);
   
    	return $this->view($sesion,200);
    }
    
    /**
     * @Rest\Post("/save")
     */
    public function guardarSesion(Request $request){
    	
    	try{
	    	$idSesion=$request->request->get('idSesion');
	    	$idTipoSesion=$request->request->get('idTipoSesion');
	    	$fecha=$request->request->get('fecha');
	    	$descripcion=$request->request->get('descripcion');
	    	$fecha.=' 00:00:00';
	    	$fechaSesion =\DateTime::createFromFormat('d/m/Y H:i:s',$fecha);
	    	$año=substr($fechaSesion->format("Y"),2,2);
	    	
	    	$sesionReposiory=$this->getDoctrine()->getRepository('AppBundle:Sesion');
	    	$tipoSesionReposiory=$this->getDoctrine()->getRepository('AppBundle:TipoSesion');
	    	$tipoSesion=$tipoSesionReposiory->find($idTipoSesion);
	    	$sesionesPersistidas=$sesionReposiory->findBy(array('tipoSesion' => $tipoSesion,'fecha' => $fechaSesion));
	    	
	    	if (count($sesionesPersistidas)>0)
	    		return $this->view('Ya existe una sesion del tipo '.
	    						   $tipoSesion->getTipoSesion().
	    						   ' creada para la misma fecha',500);
	    	
	    	$sesion=null;
	    	$mensaje="";
	    	
	    	if($idSesion==0){
	    		$sesion=new Sesion();
	    		$mensaje='La sesion fue creó en forma exitosa';
	    	}
	    	else {
	    		$sesion=$sesionReposiory->find($idSesion);
	    		$mensaje='La sesión se modifico en forma exitosa';
	    	}
	    	
	    	$sesion->setTipoSesion($tipoSesion);
	    	$sesion->setFecha($fechaSesion);
	    	$sesion->setPeriodo($año);
	    	$sesion->setDescripcion($descripcion);
	    	
	    	$em = $this->getDoctrine()->getManager();
	    	$em->persist($sesion);
	    	$em->flush();
	    
	    	return $this->view($mensaje,200);
    	}
    	catch(\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    }
    
    /**
     * @Rest\Get("/getLastByType")
     */
    public function  traerUltimasSesionesPorTipoAction(Request $request){
    	
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesionesValidas=$sesionRepository->findLastActivoByTipo();
    	return $this->view($sesionesValidas,200);
    }
        
    /**
     * @Rest\Post("/ordenDia/create")
     */
    public function  generarOrdenDelDia(Request $request){
    	
    	$idSesion=$request->request->get('idSesion');
    	
    	try {
    		$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    		$sesionRepository->createOrdenDelDia($idSesion);
    		
    		return $this->view('La orden del día se generó correctamente',200);
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    	
    }
    
    /**
     * @Rest\Post("/ordenDia/remove")
     */
    public function  borrarOrdenDelDia(Request $request){
    	
    	$idSesion=$request->request->get('idSesion');
    	
    	try {
    		$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    		$sesionRepository->removeOrdenDelDia($idSesion);
    		
    		return $this->view('La orden del día se eliminó en forma correcta',200);
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    	
    }
    
    /**
     * @Rest\Post("/ordenDia/invalidate")
     */
    public function  invalidarEdicionOrdenDelDia(Request $request){
    	
    	$idSesion=$request->request->get('idSesion');
    	
    	try {
    		$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    		$sesion=$sesionRepository->find($idSesion);
    		$sesion->setTieneEdicionBloqueada(true);
    		
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($sesion);
    		$em->flush();
    		
    		return $this->view('El bloqueo de ediciones sobre la orden del día'.
    							$sesion->getFechaMuestra().'se realizó en forma exitosa',200);
    	
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    	
    }
    
    /**
     * @Rest\Get("/getExpedienteSesionByCriteria/{idSesion}/{tipoCriterio}/{criterio}")
     */
    public function traerExpedienteSesionesPorCriterioAction(Request $request){
    	
    	$idSesion=$request->get('idSesion');
    	$tipoCriterio=$request->get('tipoCriterio');
    	$criterio=$request->get('criterio');
    	
    	//$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	//$sesion=$sesionRepository->find($idSesion);
    	$expedienteSesionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteSesion');
    	$expedientesEnSesion=null;
    	
    	if ($tipoCriterio=='todo') //todos los expedientes
    		$expedientesEnSesion=$expedienteSesionRepository->findDistinctBySesion_Id($idSesion);
    	if($tipoCriterio=='busqueda-1') //por numero de expediente sesion
    		$expedientesEnSesion=$expedienteSesionRepository->findDistinctByExpediente_Numero($criterio,$idSesion);
    	if ($tipoCriterio=='busqueda-2') //por tipo de expediente sesion
    		$expedientesEnSesion=$expedienteSesionRepository->findDistinctByTipoExpediente_Id($criterio,$idSesion);
    	if ($tipoCriterio=='busqueda-3') //estado expediente sesion
    		$expedientesEnSesion=$expedienteSesionRepository->findDistinctByletraOrdenDia($criterio,$idSesion);
    	
    	/*
    	$resutado=[];
    	foreach ($expedientesEnSesion as $expedienteSesion){
    		$registro=array('id'=>$expedienteSesion->getId(),
    						'numero_expediente'=>$expedienteSesion->getExpediente()->getNumeroCompleto(),
    						'letra_orden_dia'=>$expedienteSesion->getTipoExpedienteSesion()->getLetra(),
    						'tipo'=>$expedienteSesion->getExpediente()->getTipoExpediente()->getTipoExpediente(),
    						'tiene_resolucion'=>(!is_null($expedienteSesion->getResolucion())?'Si':'No'),
    						'mumero_sancion'=>((!is_null($expedienteSesion->getResolucion()) &&
    								   		   !($expedienteSesion->getResolucion() instanceof ResolucionBasicaSinSancion))
    												?$expedienteSesion->getResolucion()->getNumeroSancion():''
    										   )
    				
    		);
    		$resutado[]=$registro;		
    	}
    		
    	return $this->view($resutado,200);
    	*/
    		
    	return $this->view($expedientesEnSesion,200);
    }
    
    /**
     * @Rest\Get("/getDictamenesByExpediente/{idExpediente}/{idSesion}")
     */
    public function traerDictamenesPorExpediente(Request $request){
    	
    	$idExpediente=$request->get('idExpediente');
    	$idSesion=$request->get('idSesion');
    	
    	$expedienteSesionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteSesion');
    	$dictamenes=$expedienteSesionRepository->findDictamenesByExedienteYSesion($idExpediente, $idSesion);
    	
    	return $dictamenes;
    	
    }
    
    /**
     * @Rest\Get("/getSesionesByPeriodo/{periodo}")
     */
    public function traerSesionesPorPeriodoAction(Request $request){
    	
    	$periodo=$request->get('periodo');
    	
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesiones=$sesionRepository->findByPeriodo($periodo);
    	
    	return $sesiones;
    }
    
}